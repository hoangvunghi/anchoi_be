<?php

namespace App\Console\Commands;

use App\Services\GoogleOAuthService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GoogleOAuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'google:auth 
                            {action : Action to perform: login, status, logout}
                            {--code= : Authorization code from Google (for login)}';

    /**
     * The console command description.
     */
    protected $description = 'Quản lý Google OAuth authentication cho Google Maps API';

    private $googleOAuth;

    public function __construct(GoogleOAuthService $googleOAuth)
    {
        parent::__construct();
        $this->googleOAuth = $googleOAuth;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'login':
                return $this->handleLogin();
            case 'status':
                return $this->handleStatus();
            case 'logout':
                return $this->handleLogout();
            default:
                $this->error("Hành động không hợp lệ. Sử dụng: login, status, hoặc logout");
                return 1;
        }
    }

    private function handleLogin()
    {
        $this->info('🔐 Đăng nhập Google OAuth...');

        // Kiểm tra config
        if (!config('services.google.client_id') || !config('services.google.client_secret')) {
            $this->error('❌ Google OAuth chưa được cấu hình. Kiểm tra GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET trong .env');
            return 1;
        }

        $code = $this->option('code');

        if (!$code) {
            // Hiển thị URL để user truy cập
            $authUrl = $this->googleOAuth->getAuthorizationUrl();
            
            $this->newLine();
            $this->info('📋 Làm theo các bước sau:');
            $this->line('1. Mở URL này trong trình duyệt:');
            $this->newLine();
            $this->line($authUrl);
            $this->newLine();
            $this->line('2. Đăng nhập và cho phép ứng dụng truy cập');
            $this->line('3. Copy authorization code từ URL redirect');
            $this->line('4. Chạy lại command với code:');
            $this->line("   php artisan google:auth login --code=YOUR_CODE_HERE");
            $this->newLine();
            
            return 0;
        }

        // Xử lý authorization code
        try {
            $this->info('🔄 Đang xử lý authorization code...');
            $tokenData = $this->googleOAuth->exchangeCodeForToken($code);
            
            $this->info('✅ Đăng nhập thành công!');
            $this->line('🎯 Access token đã được lưu');
            
            if (isset($tokenData['refresh_token'])) {
                $this->line('🔄 Refresh token đã được lưu');
            }
            
            $this->newLine();
            $this->info('🚀 Bây giờ bạn có thể sử dụng các command import địa điểm!');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Lỗi khi xử lý authorization code: ' . $e->getMessage());
            return 1;
        }
    }

    private function handleStatus()
    {
        $this->info('📊 Trạng thái Google OAuth:');
        $this->newLine();

        // Kiểm tra config
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        
        if (!$clientId || !$clientSecret) {
            $this->error('❌ Google OAuth chưa được cấu hình');
            $this->line('💡 Thêm GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET vào .env');
            return 1;
        }

        $this->info('✅ Google OAuth đã được cấu hình');
        $this->line("   Client ID: " . substr($clientId, 0, 20) . "...");

        // Kiểm tra tokens
        $hasAccessToken = Cache::has('google_access_token');
        $hasRefreshToken = Cache::has('google_refresh_token');

        if ($hasAccessToken) {
            $this->info('✅ Access token: Có sẵn');
            $accessToken = Cache::get('google_access_token');
            $this->line("   Token: " . substr($accessToken, 0, 20) . "...");
        } else {
            $this->warn('⚠️  Access token: Không có');
        }

        if ($hasRefreshToken) {
            $this->info('✅ Refresh token: Có sẵn');
        } else {
            $this->warn('⚠️  Refresh token: Không có');
        }

        if (!$hasAccessToken && !$hasRefreshToken) {
            $this->newLine();
            $this->line('💡 Chạy command sau để đăng nhập:');
            $this->line('   php artisan google:auth login');
        } else {
            // Test API call
            try {
                $this->newLine();
                $this->info('🧪 Testing API call...');
                $accessToken = $this->googleOAuth->getValidAccessToken();
                $this->info('✅ API call thành công - tokens hoạt động bình thường');
            } catch (\Exception $e) {
                $this->error('❌ Lỗi khi test API: ' . $e->getMessage());
                $this->line('💡 Thử đăng nhập lại: php artisan google:auth login');
            }
        }

        return 0;
    }

    private function handleLogout()
    {
        $this->info('🚪 Đăng xuất Google OAuth...');

        $this->googleOAuth->clearTokens();
        
        $this->info('✅ Đã xóa tất cả tokens');
        $this->line('💡 Chạy "php artisan google:auth login" để đăng nhập lại');

        return 0;
    }
} 