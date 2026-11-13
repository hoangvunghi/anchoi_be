<?php

namespace App\Console\Commands;

use App\Services\GoogleOAuthService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use OpenAI\Laravel\Facades\OpenAI;

class TestApiConnectionCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'location:test-api-connection';

    /**
     * The console command description.
     */
    protected $description = 'Kiểm tra kết nối với Google Maps API và OpenAI API';

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
        $this->info('🔍 Đang kiểm tra kết nối API...');
        $this->newLine();

        $allPassed = true;

        // Test Google Maps API
        $allPassed &= $this->testGoogleMapsApi();
        $this->newLine();

        // Test OpenAI API
        $allPassed &= $this->testOpenAiApi();
        $this->newLine();

        if ($allPassed) {
            $this->info('✅ Tất cả API đã sẵn sàng! Bạn có thể bắt đầu import địa điểm.');
        } else {
            $this->error('❌ Một số API chưa hoạt động. Vui lòng kiểm tra cấu hình.');
            return 1;
        }

        return 0;
    }

    private function testGoogleMapsApi()
    {
        $this->info('🗺️  Kiểm tra Google Maps API với OAuth...');

        // Kiểm tra OAuth config
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        
        if (!$clientId || !$clientSecret) {
            $this->error('   ❌ Google OAuth chưa được cấu hình');
            $this->line('   💡 Thêm GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET vào file .env');
            return false;
        }

        // Kiểm tra có tokens không
        if (!$this->googleOAuth->hasValidTokens()) {
            $this->error('   ❌ Chưa đăng nhập Google OAuth');
            $this->line('   💡 Chạy: php artisan google:auth login');
            return false;
        }

        try {
            // Test với một request đơn giản tới Places API
            $requestData = [
                'includedTypes' => ['restaurant'],
                'maxResultCount' => 1,
                'locationRestriction' => [
                    'circle' => [
                        'center' => [
                            'latitude' => 10.762622,
                            'longitude' => 106.660172
                        ],
                        'radius' => 100.0
                    ]
                ]
            ];

            $headers = [
                'X-Goog-FieldMask' => 'places.displayName'
            ];

            $response = $this->googleOAuth->makeApiRequest('POST', 'https://places.googleapis.com/v1/places:searchNearby', $requestData, $headers);

            if ($response->successful()) {
                $this->info('   ✅ Google Maps API hoạt động bình thường');
                $data = $response->json();
                $placeCount = isset($data['places']) ? count($data['places']) : 0;
                $this->line("   📍 Tìm thấy {$placeCount} địa điểm trong khu vực test");
                return true;
            } else {
                $this->error('   ❌ Google Maps API trả về lỗi: ' . $response->status());
                $this->line('   📄 Response: ' . $response->body());
                
                if ($response->status() === 403) {
                    $this->line('   💡 Kiểm tra:');
                    $this->line('      - OAuth tokens có hợp lệ không');
                    $this->line('      - Places API (New) đã được bật chưa');
                    $this->line('      - Billing account đã được setup chưa');
                }
                
                return false;
            }
        } catch (\Exception $e) {
            $this->error('   ❌ Lỗi kết nối Google Maps API: ' . $e->getMessage());
            return false;
        }
    }

    private function testOpenAiApi()
    {
        $this->info('🤖 Kiểm tra OpenAI API (Vision)...');

        $apiKey = config('services.openai.api_key');
        
        if (!$apiKey || $apiKey === 'your_openai_api_key_here') {
            $this->warn('   ⚠️  OpenAI API key chưa được cấu hình');
            $this->line('   💡 Thêm OPENAI_API_KEY vào file .env để sử dụng mô tả hình ảnh tự động');
            return true; // Không bắt buộc
        }

        try {
            $imageUrl = "https://upload.wikimedia.org/wikipedia/commons/4/47/PNG_transparency_demonstration_1.png";

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4-vision-preview',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => 'Mô tả hình ảnh sau đây bằng tiếng Việt.'],
                            ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]],
                        ],
                    ],
                ],
                'max_tokens' => 100,
            ]);

            if (isset($response->choices[0]->message->content)) {
                $this->info('   ✅ OpenAI Vision API hoạt động bình thường');
                $this->line('   🖼️  Mô tả ảnh: ' . $response->choices[0]->message->content);
                return true;
            } else {
                $this->error('   ❌ OpenAI API trả về response không hợp lệ');
                return false;
            }
        } catch (\Exception $e) {
            $this->error('   ❌ Lỗi kết nối OpenAI API: ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'API key') !== false) {
                $this->line('   💡 Kiểm tra API key có chính xác không');
            } elseif (strpos($e->getMessage(), 'quota') !== false) {
                $this->line('   💡 Đã vượt quota, kiểm tra billing account');
            } elseif (strpos($e->getMessage(), 'model') !== false) {
                $this->line('   💡 Kiểm tra xem bạn đã được cấp quyền dùng model gpt-4-vision-preview chưa');
            }

            return false;
        }
    }
} 