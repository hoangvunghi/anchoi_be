# Workflow: Thêm Địa Điểm Tự Động

## Mô tả tổng quan
Workflow này tự động hóa việc thu thập thông tin địa điểm từ Google Maps API, tạo nội dung mô tả bằng ChatGPT, và lưu vào database.

## Các bước thực hiện

### 1. Thu thập dữ liệu từ Google Maps API
- **Endpoint**: `https://places.googleapis.com/v1/places:searchNearby`
- **Method**: POST
- **Headers**:
  - `Content-Type: application/json`
  - `X-Goog-Api-Key: [API_KEY]`
  - `X-Goog-FieldMask: places.displayName,places.photos,places.formattedAddress,places.location,places.rating,places.types,places.websiteUri,places.internationalPhoneNumber`

#### Tham số request:
```json
{
  "includedTypes": ["restaurant"],
  "maxResultCount": 10,
  "locationRestriction": {
    "circle": {
      "center": {
        "latitude": 37.7937,
        "longitude": -122.3965
      },
      "radius": 500.0
    }
  }
}
```

### 2. Xử lý dữ liệu response
- Lấy thông tin cơ bản: tên, địa chỉ, tọa độ, rating, loại hình
- Lấy thông tin liên hệ: website, số điện thoại
- Lấy danh sách ảnh và photo references

### 3. Tải ảnh từ Google Maps
- Sử dụng Photo API để lấy ảnh chất lượng cao
- **Endpoint**: `https://places.googleapis.com/v1/places/{place_id}/photos/{photo_reference}/media`
- Lưu ảnh vào storage local hoặc cloud

### 4. Tạo nội dung với ChatGPT
- Gửi thông tin địa điểm + ảnh cho ChatGPT
- Yêu cầu viết bài giới thiệu về địa điểm
- Include: mô tả chi tiết, đặc điểm nổi bật, khuyến nghị

#### Prompt template:
```
Hãy viết một bài giới thiệu về nhà hàng/địa điểm sau:
- Tên: {displayName}
- Địa chỉ: {formattedAddress}
- Loại hình: {types}
- Rating: {rating}
- Website: {websiteUri}

Yêu cầu:
- Viết bằng tiếng Việt
- Độ dài khoảng 200-300 từ
- Tập trung vào đặc điểm nổi bật và trải nghiệm của khách hàng
- Tone tích cực, thu hút
```

### 5. Chuẩn bị dữ liệu cho database
Tạo object với các trường:
- `name`: Tên địa điểm
- `description`: Nội dung từ ChatGPT
- `address`: Địa chỉ
- `latitude`, `longitude`: Tọa độ
- `rating`: Đánh giá
- `types`: Loại hình kinh doanh
- `website`: Website
- `phone`: Số điện thoại
- `photos`: Array các đường dẫn ảnh
- `created_at`: Timestamp
- `source`: "google_maps"

### 6. Lưu vào database
- Insert dữ liệu vào bảng locations
- Xử lý duplicate dựa trên tọa độ hoặc place_id
- Log kết quả thành công/thất bại

## Lưu ý kỹ thuật
- Rate limiting: Google Maps API có giới hạn request
- Error handling: Xử lý lỗi API, network timeout
- Data validation: Kiểm tra tính hợp lệ của dữ liệu trước khi lưu
- Backup: Lưu raw data từ API để có thể xử lý lại nếu cần

## Dependencies cần thiết
- HTTP client (axios/fetch)
- File system operations
- Database ORM/client
- Image processing library
- OpenAI API client
- Environment variables management 