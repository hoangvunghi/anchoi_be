#!/bin/bash

echo "🚀 Thiết lập môi trường import địa điểm từ Google Maps"
echo "=================================================="

# Kiểm tra composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer không được tìm thấy. Vui lòng cài đặt Composer trước."
    exit 1
fi

# Cài đặt OpenAI package
echo "📦 Đang cài đặt OpenAI Laravel package..."
composer require openai-php/laravel

# Publish config nếu cần
if [ ! -f config/openai.php ]; then
    echo "📝 Publishing OpenAI config..."
    php artisan vendor:publish --provider="OpenAI\Laravel\ServiceProvider"
fi

# Tạo thư mục lưu ảnh
echo "📁 Tạo thư mục lưu ảnh..."
mkdir -p storage/app/public/places
chmod 755 storage/app/public/places

# Tạo symlink storage nếu chưa có
if [ ! -L public/storage ]; then
    echo "🔗 Tạo storage symlink..."
    php artisan storage:link
fi

# Kiểm tra file .env
if [ ! -f .env ]; then
    echo "❌ File .env không tồn tại. Vui lòng tạo file .env từ .env.example"
    exit 1
fi

# Kiểm tra API keys trong .env
echo "🔑 Kiểm tra cấu hình API keys..."

if ! grep -q "GOOGLE_CLIENT_ID=" .env; then
    echo "📝 Thêm Google OAuth config vào .env..."
    echo "" >> .env
    echo "# Google OAuth Configuration" >> .env
    echo "GOOGLE_CLIENT_ID=your_google_client_id_here" >> .env
    echo "GOOGLE_CLIENT_SECRET=your_google_client_secret_here" >> .env
    echo "GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback" >> .env
fi

if ! grep -q "OPENAI_API_KEY=" .env; then
    echo "📝 Thêm OPENAI_API_KEY vào .env..."
    echo "" >> .env
    echo "# OpenAI API Configuration" >> .env
    echo "OPENAI_API_KEY=your_openai_api_key_here" >> .env
fi

# Clear cache
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear

echo ""
echo "✅ Thiết lập hoàn tất!"
echo ""
echo "📋 Các bước tiếp theo:"
echo "1. Tạo Google OAuth 2.0 credentials tại Google Cloud Console"
echo "2. Cập nhật GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET trong file .env"
echo "3. Cập nhật OPENAI_API_KEY trong file .env (optional)"
echo "4. Đảm bảo Google Cloud Project có các API:"
echo "   - Places API (New)"
echo "   - Photos API"
echo ""
echo "🔐 Đăng nhập Google OAuth:"
echo "   php artisan google:auth login"
echo ""
echo "🎯 Sử dụng commands:"
echo "   php artisan location:list-wards --search=\"Quận 1\""
echo "   php artisan location:import-from-google-maps --lat=10.762622 --lng=106.660172 --ward-id=123"
echo ""
echo "📖 Xem thêm hướng dẫn chi tiết trong file: IMPORT_LOCATIONS_README.md" 