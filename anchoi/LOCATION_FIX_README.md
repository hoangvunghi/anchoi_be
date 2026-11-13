# Fix: Location Request Issue

## Vấn đề
- Trình duyệt hỏi vị trí liên tục mỗi lần load trang
- User bị làm phiền bởi popup permission

## Giải pháp đã áp dụng

### 1. Backend (EntertainmentSpotController.php)
- ✅ Tăng thời gian cache vị trí từ **5 phút** → **24 giờ**
- Session sẽ giữ vị trí user trong 24 giờ thay vì 5 phút

### 2. Frontend (JavaScript)
- ✅ Sử dụng **localStorage** để track lần hỏi cuối cùng
- ✅ Chỉ hỏi vị trí **1 lần trong 24 giờ**
- ✅ Kiểm tra server trước khi hỏi browser
- ✅ Loại bỏ alert() để không làm phiền user
- ✅ Tối ưu geolocation options:
  - `enableHighAccuracy: false` - Tiết kiệm pin
  - `timeout: 10000` - Timeout sau 10s
  - `maximumAge: 3600000` - Cache 1 giờ

### 3. File JavaScript tập trung
Đã tạo file `/public/js/location.js` để tái sử dụng code.

## Cách sử dụng trong views

### Option 1: Include file JS (Khuyến nghị)
```html
<script src="{{ asset('js/location.js') }}"></script>
```

### Option 2: Inline (Đã cập nhật trong home.blade.php và detail.blade.php)
Code đã được fix trực tiếp trong các file view chính.

## Files đã được fix
- ✅ `app/Http/Controllers/EntertainmentSpotController.php`
- ✅ `resources/views/home.blade.php`
- ✅ `resources/views/detail.blade.php`
- ✅ `public/js/location.js` (Mới tạo)

## Files cần update (Optional)
Các file sau vẫn dùng code cũ, có thể update sau:
- `resources/views/searchResult.blade.php`
- `resources/views/404.blade.php`
- `resources/views/contact.blade.php`
- `resources/views/homeBlog.blade.php`
- `resources/views/near.blade.php`
- `resources/views/blogDetail.blade.php`

**Khuyến nghị:** Thay thế inline JavaScript bằng:
```html
<script src="{{ asset('js/location.js') }}"></script>
```

## Testing
1. Clear browser cache và localStorage
2. Truy cập trang web
3. Cho phép location một lần
4. Reload trang → Không hỏi lại nữa
5. Check console log: "Đã hỏi vị trí gần đây, bỏ qua"

## Notes
- User có thể clear localStorage để reset
- Session backend expire sau 24 giờ
- LocalStorage expire sau 24 giờ
- Geolocation cache 1 giờ trong browser
