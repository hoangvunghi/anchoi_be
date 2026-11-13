# Trả lời câu hỏi phỏng vấn: Kinh nghiệm MySQL và Tối ưu hóa hiệu năng (Role: Team Lead - PHP Laravel & MySQL)

Chào bạn, với vai trò là Team Lead trong dự án sử dụng Laravel và MySQL, kinh nghiệm thực tế của mình không chỉ dừng lại ở việc viết query sao cho chạy được, mà còn là thiết kế hệ thống dữ liệu có khả năng mở rộng (scalable), review code của các thành viên để ngăn chặn query/schema xấu, và liên tục monitor hiệu năng cơ sở dữ liệu.

Dưới đây là chi tiết về kinh nghiệm và các phương pháp mình đã áp dụng để tối ưu hóa hiệu năng (Performance Optimization) cho hệ thống:

## 1. Kinh nghiệm thực tế với MySQL ở góc độ Team Lead

*   **Thiết kế Schema và Chuẩn hóa (Database Design):** Mình chịu trách nhiệm review và thiết kế ERD (Entity Relationship Diagram). Mình áp dụng các nguyên tắc chuẩn hóa (Normalization - 1NF, 2NF, 3NF) để tránh dư thừa, toàn vẹn dữ liệu. Tuy nhiên, mình cũng quyết định/duyệt những chỗ cần "phi chuẩn hóa" (Denormalization) hợp lý để tăng tốc độ truy vấn ở các màn hình Dashboard/Thống kê phức tạp.
*   **Lựa chọn Data Types tối ưu:** Yêu cầu team chọn tối ưu kiểu dữ liệu đúng và đủ để tiết kiệm disk space và RAM cho Index buffer. Ví dụ: Dùng `TINYINT` cho các trạng thái (status), dùng `VARCHAR` có độ dài phù hợp thay vì `TEXT` bừa bãi, cân nhắc giới hạn khi dùng kiểu `JSON` (rất linh hoạt trong Laravel nhưng không thể đánh index b-tree trực tiếp dẫn đến chậm khi query filter).
*   **Quản lý DB Migration & Seeder bài bản:** Setup quy trình chuẩn trong việc viết Migration để đảm bảo cấu trúc database giữa các môi trường (Dev, Staging, Prod) luôn đồng bộ. Khi thay đổi cấu trúc bảng lớn (hàng triệu rows) trên Production, phải có phương án thiết kế chạy migration không gây khoá bảng / downtime (Zero-downtime migration).

## 2. Các bước tiến hành Performance Optimization cho truy vấn MySQL

Để đảm bảo hệ thống chạy nhanh, đặc biệt là khi dữ liệu và lượng người dùng tăng lên, mình đã áp dụng các chiến lược sau:

### Bước 1: Giám sát và Xác định điểm nghẽn (Monitoring & Profiling)
*   Bật và theo dõi **MySQL Slow Query Log** trên server để bắt các query mất > 1 giây.
*   Trên môi trường Dev/Staging, dùng **Laravel Telescope** hoặc **Laravel Debugbar** để xem mỗi request tốn bao nhiêu query, duplicated query và thời gian chạy là bao lâu.
*   Sử dụng `DB::listen` trong `AppServiceProvider` để log lại các query chạy lâu vào Slack/Log channel để cảnh báo sớm.

### Bước 2: Triệt tiêu vấn đề N+1 Query triệt để
*   Trong Laravel Eloquent, N+1 là nguyên nhân phổ biến nhất gây chậm. Mình đặt ra quy tắc hoặc rule review code bắt buộc phải dùng **Eager Loading** (`with()`, `load()`, `loadMissing()`) khi gọi các relation trong một danh sách lặp.
*   Sử dụng tính năng `Model::preventLazyLoading(!app()->isProduction())` (từ Laravel 8+) trên môi trường local. Nó sẽ throw Exception báo lỗi ngay lập tức nếu Dev viết code gọi Lazy Load, giúp chặn bug performance ngay từ lúc code.

### Bước 3: Tối ưu hóa Indexing (Đánh chỉ mục đúng cách)
*   Luôn luôn sử dụng **`EXPLAIN`** (hoặc `EXPLAIN FORMAT=JSON`) trước mọi truy vấn chậm để đọc Execution Plan (nhìn xem `type` là ALL hay ref, `possible_keys`, `rows` phải quét...).
*   **Composite Index (Multi-column Index):** Khi mệnh đề `WHERE` thường xuyên kết hợp 2-3 cột (ví dụ: `WHERE status = 1 AND created_at > ?`), mình sẽ tạo Composite Index thay vì Single Index rời rạc cho từng cột để tránh Index Merge kém hiệu quả.
*   **Tuân thủ Leftmost Prefix Rule:** Khi dùng Composite Index (A, B, C), query phải tuân thủ nguyên lý nối trái nhất (`WHERE A` hoặc `WHERE A và B`), nếu chỉ `WHERE B` thì Index sẽ không hoạt động.
*   Thiết kế Index cover (Covering Index): Làm sao để Index chứa luôn cả dữ liệu cần Select, khi đó MySQL chỉ cần đọc từ cây Index mà không cần bookmark lookup về dữ liệu bảng chính.

### Bước 4: Refactor Query và tối ưu ở mức Laravel / PHP
*   **Nói "Không" với Select *:** Không lấy dư thừa cột (`Model::all()`). Yêu cầu dùng `select(['id', 'title', 'created_at'])` ở cả model chính và khi eager load (`with(['relation:id,title'])`), giúp tiết kiệm Data Transfer và RAM phía PHP.
*   **Thay thế Sub-query và Eloquent phức tạp:** ORM đôi khi map ra các Subquery rất chậm. Khi query phức tạp, mình yêu cầu thành viên hạ cấp xuống dùng Query Builder (`DB::table`) để viết `JOIN` rõ ràng.
*   **Xử lý Big Data bằng Chunk / Cursor:** Đối với các tác vụ background job (ví dụ: gửi mail cho 50,000 users, export Excel), tuyệt đối không dùng `get()` (sẽ gây Out Of Memory), mà dùng `chunkById(1000)` hoặc `cursor()` chỉ fetch 1 record/1 khối tại 1 thời điểm lên RAM.

### Bước 5: Áp dụng Caching & Database Caching
*   Dùng **Redis / Memcached** để cache lại các Query Result (đã serialize) của các API ít thay đổi dữ liệu nhưng hay được gọi (như danh sách settings, master data).
*   **Bảng tổng hợp (Aggregate / Reporting Tables):** Đặc trưng xử lý OLTP của MySQL không giỏi trong việc Group By / Count ở bảng dung lượng quá lớn. Mình thường thiết kế Cronjob/Queue thống kê số liệu vào ban đêm hoặc theo event, insert kết quả vào các bảng `daily_reports`, giúp các query mở Dashboard hệ thống Load tức thì.

Bằng cách phân luồng tối ưu (từ schema, index, query ORM, tới cache), mình đảm bảo rằng database giảm tải rõ rệt, CPU/IOPS ổn định và thời gian phản hồi API luôn đạt chuẩn kỳ vọng cho cả hệ thống.
