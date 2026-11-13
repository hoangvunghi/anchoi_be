# Hướng Dẫn Thiết Lập Google OAuth 2.0

## Tại sao sử dụng OAuth 2.0?

Google OAuth 2.0 có nhiều ưu điểm so với API key:
- **Bảo mật cao hơn**: Tokens có thời gian hết hạn, có thể revoke
- **Quota cao hơn**: Thường có giới hạn request cao hơn API key
- **Kiểm soát quyền**: Chỉ yêu cầu quyền cần thiết
- **Audit tốt hơn**: Theo dõi usage chi tiết

## Bước 1: Tạo Google Cloud Project

1. Truy cập [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo project mới hoặc chọn project hiện có
3. Ghi nhớ Project ID để sử dụng sau

## Bước 2: Bật APIs cần thiết

1. Vào **APIs & Services > Library**
2. Tìm và bật các API sau:
   - **Places API (New)** - Để tìm kiếm địa điểm
   - **Places API (Photos)** - Để tải ảnh địa điểm

## Bước 3: Tạo OAuth 2.0 Credentials

1. Vào **APIs & Services > Credentials**
2. Click **+ CREATE CREDENTIALS > OAuth 2.0 Client IDs**
3. Nếu chưa có OAuth consent screen, tạo trước:
   - Chọn **External** user type
   - Điền thông tin ứng dụng
   - Thêm scopes: `https://www.googleapis.com/auth/places`
   - Thêm test users nếu app chưa publish

4. Tạo OAuth Client ID:
   - Application type: **Web application**
   - Name: `Anchoi Location Import`
   - Authorized redirect URIs: `http://localhost:8000/auth/google/callback`

5. Download JSON file chứa credentials

## Bước 4: Cấu hình .env

Thêm vào file `.env`:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Bước 5: Đăng nhập OAuth

1. Chạy command đăng nhập:
```bash
php artisan google:auth login
```

2. Copy URL hiển thị và mở trong trình duyệt

3. Đăng nhập Google và cho phép quyền truy cập

4. Copy authorization code từ URL redirect

5. Chạy lại command với code:
```bash
php artisan google:auth login --code=4/0AX4XfWi...
```

## Bước 6: Kiểm tra kết nối

```bash
# Kiểm tra trạng thái OAuth
php artisan google:auth status

# Test API connection
php artisan location:test-api-connection
```

## Các Commands OAuth

### Đăng nhập
```bash
php artisan google:auth login
```

### Kiểm tra trạng thái
```bash
php artisan google:auth status
```

### Đăng xuất
```bash
php artisan google:auth logout
```

## Troubleshooting

### Lỗi "invalid_client"
- Kiểm tra GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET
- Đảm bảo redirect URI khớp với cấu hình

### Lỗi "access_denied"
- User từ chối cấp quyền
- Thử lại quá trình đăng nhập

### Lỗi "invalid_grant"
- Authorization code đã hết hạn (10 phút)
- Lấy authorization code mới

### Lỗi "insufficient_permissions" 
- Kiểm tra OAuth consent screen đã có scope Places API
- Đảm bảo Places API đã được bật

### Token hết hạn
- Hệ thống tự động refresh token
- Nếu vẫn lỗi, đăng nhập lại

## Security Notes

- **Không commit** credentials vào Git
- **Sử dụng HTTPS** trong production
- **Thường xuyên rotate** credentials
- **Monitor usage** để phát hiện bất thường

## Production Setup

Trong production, cần:
1. Thay đổi redirect URI thành domain thực
2. Publish OAuth consent screen
3. Sử dụng HTTPS
4. Cấu hình proper caching cho tokens

## Rate Limits

OAuth thường có limits cao hơn:
- **Places API**: 100,000 requests/day
- **Photos API**: 100,000 requests/day

Specific limits có thể khác tùy project và billing setup. 