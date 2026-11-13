# Hướng Dẫn Import Địa Điểm Từ Google Maps

## Tổng quan
Hệ thống này cho phép tự động import địa điểm từ Google Maps API, tạo mô tả bằng ChatGPT và lưu vào database.

## Cài đặt ban đầu

### 1. Cấu hình Google OAuth 2.0
Thêm các key sau vào file `.env`:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# OpenAI API Key (để tạo mô tả tự động)
OPENAI_API_KEY=your_openai_api_key_here
```

📖 **Xem hướng dẫn chi tiết**: [GOOGLE_OAUTH_SETUP.md](GOOGLE_OAUTH_SETUP.md)

### 2. Cài đặt dependencies
```bash
composer require openai-php/laravel
composer install
```

### 3. Đăng nhập Google OAuth
```bash
# Đăng nhập và lấy authorization code
php artisan google:auth login

# Kiểm tra trạng thái
php artisan google:auth status
```

### 4. Kiểm tra kết nối API
```bash
php artisan location:test-api-connection
```

### 5. Tạo thư mục lưu ảnh
```bash
php artisan storage:link
mkdir -p storage/app/public/places
```

## Sử dụng

### Bước 1: Kiểm tra Ward ID có sẵn
```bash
# Liệt kê tất cả ward
php artisan location:list-wards

# Lọc theo tỉnh
php artisan location:list-wards --province="Hồ Chí Minh"

# Tìm kiếm ward cụ thể
php artisan location:list-wards --search="Quận 1"

# Giới hạn kết quả
php artisan location:list-wards --limit=50
```

### Bước 2: Import địa điểm từ Google Maps

#### Cách sử dụng cơ bản
```bash
php artisan location:import-from-google-maps \
  --lat=10.762622 \
  --lng=106.660172 \
  --ward-id=123
```

#### Với tùy chọn đầy đủ
```bash
php artisan location:import-from-google-maps \
  --lat=10.762622 \
  --lng=106.660172 \
  --radius=1000 \
  --type=restaurant \
  --limit=20 \
  --ward-id=123
```

#### Các tham số có sẵn:
- `--lat`: Latitude của vị trí trung tâm (bắt buộc)
- `--lng`: Longitude của vị trí trung tâm (bắt buộc)
- `--radius`: Bán kính tìm kiếm tính bằng mét (mặc định: 500)
- `--type`: Loại địa điểm (mặc định: restaurant)
- `--limit`: Số lượng địa điểm tối đa (mặc định: 10)
- `--ward-id`: ID của ward để gán cho địa điểm (bắt buộc)

#### Các loại địa điểm hỗ trợ:
- `restaurant` - Nhà hàng
- `cafe` - Quán cà phê
- `tourist_attraction` - Điểm du lịch
- `amusement_park` - Công viên giải trí
- `shopping_mall` - Trung tâm thương mại
- `hotel` - Khách sạn
- `bar` - Quán bar
- `night_club` - Hộp đêm
- `spa` - Spa
- `gym` - Phòng gym

## Ví dụ thực tế

### Import nhà hàng quanh Bến Thành Market
```bash
# Lấy ward ID cho Quận 1
php artisan location:list-wards --search="Bến Thành"

# Import (giả sử ward ID là 123)
php artisan location:import-from-google-maps \
  --lat=10.772431 \
  --lng=106.698068 \
  --radius=800 \
  --type=restaurant \
  --limit=15 \
  --ward-id=123
```

### Import quán cà phê quanh Landmark 81
```bash
php artisan location:import-from-google-maps \
  --lat=10.795658 \
  --lng=106.721732 \
  --radius=600 \
  --type=cafe \
  --limit=10 \
  --ward-id=456
```

### Import điểm du lịch quanh Hồ Hoàn Kiếm (Hà Nội)
```bash
php artisan location:import-from-google-maps \
  --lat=21.028228 \
  --lng=105.854200 \
  --radius=1000 \
  --type=tourist_attraction \
  --limit=20 \
  --ward-id=789
```

## Quy trình hoạt động

1. **Gọi Google Maps API**: Tìm kiếm địa điểm theo tọa độ và bán kính
2. **Kiểm tra trùng lặp**: Không import địa điểm đã tồn tại
3. **Tải ảnh**: Download tối đa 3 ảnh từ Google Photos API
4. **Tạo mô tả**: Sử dụng ChatGPT để viết mô tả hấp dẫn
5. **Lưu database**: Insert vào bảng `diem_vui_choi`

## Dữ liệu được lưu

Mỗi địa điểm sẽ có các thông tin:
- **Thông tin cơ bản**: Tên, địa chỉ, tọa độ
- **Liên hệ**: Số điện thoại, website
- **Đánh giá**: Rating từ Google Maps
- **Mô tả**: Nội dung được tạo bởi ChatGPT
- **Ảnh**: Banner và ảnh bổ sung
- **Metadata**: Google Place ID, loại hình, nguồn dữ liệu

## Troubleshooting

### Lỗi thường gặp:

1. **"Google OAuth chưa được thiết lập"**
   - Chạy `php artisan google:auth login` để đăng nhập
   - Kiểm tra biến `GOOGLE_CLIENT_ID` và `GOOGLE_CLIENT_SECRET` trong file `.env`
   - Đảm bảo OAuth đã có quyền truy cập Places API

2. **"Không tìm thấy địa điểm nào"**
   - Thử tăng `--radius`
   - Thay đổi `--type` cho phù hợp
   - Kiểm tra tọa độ có chính xác không

3. **Lỗi tải ảnh**
   - Kiểm tra quyền ghi thư mục `storage/app/public/places`
   - Đảm bảo Photos API được bật

4. **ChatGPT không hoạt động**
   - Kiểm tra `OPENAI_API_KEY`
   - Hệ thống sẽ tự động tạo mô tả dự phong

### Logs và debugging:
```bash
# Xem log lỗi
tail -f storage/logs/laravel.log

# Chạy command với debug
php artisan location:import-from-google-maps --lat=10.762622 --lng=106.660172 --ward-id=123 -vvv
```

## Rate Limiting

- **Google Maps API**: 10 requests/second
- **OpenAI API**: 3 requests/minute (free tier)
- Command tự động xử lý rate limiting

## Best Practices

1. **Chọn bán kính hợp lý**: 500-1000m cho khu vực đông đúc
2. **Giới hạn số lượng**: 10-20 địa điểm mỗi lần để tránh timeout
3. **Chạy theo batch**: Import từng khu vực nhỏ
4. **Backup trước khi import**: Đề phòng lỗi không mong muốn
5. **Kiểm tra dữ liệu**: Review kết quả sau mỗi lần import

## Performance Tips

- Chạy command vào giờ thấp điểm để tránh ảnh hưởng user
- Sử dụng queue cho import lớn (có thể customize)
- Monitor API usage để tránh vượt quota
- Cache ward data để tăng tốc độ lookup 