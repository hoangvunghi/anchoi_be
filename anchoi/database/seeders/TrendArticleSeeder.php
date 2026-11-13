<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TrendArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(['name' => 'Tin tức']);

        $title = 'Xu hướng địa điểm giải trí Việt Nam 2025: karaoke đa dịch vụ, pub "chill" và trào lưu "xõa riêng tư"';

        $body = <<<'HTML'
<p>Thị trường địa điểm ăn chơi, giải trí tại Việt Nam năm 2025 đang thay đổi nhanh theo thói quen của người trẻ. Từ karaoke, pub cho tới cách người ta "đi chơi", mô hình nào cũng phải thích nghi. Dưới đây là những xu hướng đáng chú ý nhất, tổng hợp từ các nguồn trong ngành.</p>

<h2>Karaoke chuyển mình thành tổ hợp đa dịch vụ</h2>
<p>Thay vì chỉ có phòng hát, nhiều cơ sở karaoke nay ghép thêm nhà hàng, bar hoặc lounge trong cùng một địa điểm. Khách có thể ăn tối, uống nước rồi hát mà không phải di chuyển. Mô hình "karaoke + ẩm thực" được xem là hướng đi nổi bật sau giai đoạn hậu Covid-19, giúp tăng thời gian khách ở lại và giá trị mỗi lượt sử dụng.</p>

<h2>Làn sóng karaoke phong cách Hàn Quốc và cafe hát</h2>
<p>Các phòng hát thiết kế theo phong cách Hàn Quốc (noraebang) với không gian khép kín, trang trí riêng cho từng phòng đang gây sốt, đặc biệt ở Hà Nội và TP.HCM. Bên cạnh đó, mô hình cafe karaoke theo hướng không gian gia đình, ấm cúng cũng nở rộ, nhắm tới nhóm bạn bè và gia đình thay vì tiệc tùng ồn ào.</p>

<h2>Công nghệ và góc "check-in" lên ngôi</h2>
<p>Giới trẻ ngày càng ưu tiên những địa điểm có thiết kế đẹp để chụp ảnh, kèm trải nghiệm công nghệ như màn hình cảm ứng chọn bài, đặt phòng online. Một không gian "sống ảo" tốt gần như trở thành yêu cầu bắt buộc, chứ không còn là điểm cộng.</p>

<h2>Pub và bar: "chill hơn là quẩy"</h2>
<p>Bên cạnh các bar sôi động, pub đang được ưa chuộng nhờ không khí nhẹ nhàng, hợp để trò chuyện. Xu hướng "chill hơn là quẩy" phản ánh nhu cầu thư giãn sau giờ làm thay vì chỉ tìm chỗ náo nhiệt. Các rooftop, sky lounge với tầm nhìn đẹp vẫn giữ sức hút riêng.</p>

<h2>Trào lưu "xõa riêng tư": thuê homestay thay vì ra quán</h2>
<p>Một bộ phận người trẻ chọn thuê căn hộ, homestay theo ngày để tự nấu nướng, chơi game, tiệc tùng và trò chuyện xuyên đêm — một kiểu "đi chơi tại gia" riêng tư và tiết kiệm. Trào lưu này rõ nhất ở các đô thị lớn như TP.HCM và Hà Nội, đặt ra thách thức cạnh tranh mới cho các quán xá truyền thống.</p>

<h2>Tạm kết</h2>
<p>Điểm chung của mọi xu hướng 2025 là cá nhân hóa trải nghiệm: không gian riêng tư hơn, đa dịch vụ hơn và "đẹp để chụp ảnh" hơn. Với người đi chơi, lựa chọn ngày càng phong phú; với chủ địa điểm, ai bắt kịp thói quen mới sẽ thắng.</p>

<p><em>Bài viết tổng hợp và biên tập từ các nguồn trong ngành; thông tin địa điểm, giờ mở cửa có thể thay đổi, vui lòng kiểm tra lại trước khi đến.</em></p>
HTML;

        Blog::firstOrNew(['title' => $title])
            ->fill(['body' => $body, 'category_id' => $category->id])
            ->save();

        $this->command->info('Đã đăng bài xu hướng giải trí 2025.');
    }
}
