<?php

namespace App\Console\Commands;

use App\Models\EntertainmentSpot;
use App\Models\Ward;
use App\Services\GoogleOAuthService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;

class ImportLocationFromGoogleMapsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'location:import-from-google-maps 
                            {--lat= : Latitude của vị trí trung tâm}
                            {--lng= : Longitude của vị trí trung tâm}
                            {--radius=500 : Bán kính tìm kiếm (mét)}
                            {--type=restaurant : Loại địa điểm cần tìm}
                            {--limit=10 : Số lượng địa điểm tối đa}
                            {--ward-id= : ID của phường/xã để gán cho địa điểm}';

    /**
     * The console command description.
     */
    protected $description = 'Import địa điểm từ Google Maps API, tạo mô tả bằng ChatGPT và lưu vào database';

    private $googleOAuth;
    private $placesApiUrl = 'https://places.googleapis.com/v1/places:searchNearby';
    private $photosApiUrl = 'https://places.googleapis.com/v1/places';

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
        // Kiểm tra OAuth authentication
        if (!$this->googleOAuth->hasValidTokens()) {
            $this->error('Google OAuth chưa được thiết lập. Chạy "php artisan google:auth login" để đăng nhập');
            return 1;
        }

        // Lấy parameters
        $latitude = $this->option('lat') ?? $this->ask('Nhập latitude');
        $longitude = $this->option('lng') ?? $this->ask('Nhập longitude');
        $radius = $this->option('radius');
        $type = $this->option('type');
        $limit = $this->option('limit');
        $wardId = $this->option('ward-id') ?? $this->ask('Nhập Ward ID');

        if (!$latitude || !$longitude) {
            $this->error('Vui lòng nhập latitude và longitude');
            return 1;
        }

        $this->info("Bắt đầu tìm kiếm địa điểm...");
        $this->info("Vị trí: {$latitude}, {$longitude}");
        $this->info("Bán kính: {$radius}m");
        $this->info("Loại: {$type}");
        $this->info("Giới hạn: {$limit} địa điểm");

        try {
            // Bước 1: Gọi Google Maps API để lấy danh sách địa điểm
            $places = $this->searchNearbyPlaces($latitude, $longitude, $radius, $type, $limit);
            
            if (empty($places)) {
                $this->warn('Không tìm thấy địa điểm nào trong khu vực này');
                return 0;
            }

            $this->info("Đã tìm thấy " . count($places) . " địa điểm");

            // Bước 2: Xử lý từng địa điểm
            $progressBar = $this->output->createProgressBar(count($places));
            $progressBar->start();

            $successCount = 0;
            foreach ($places as $place) {
                try {
                    if ($this->processPlace($place, $wardId)) {
                        $successCount++;
                    }
                                 } catch (\Exception $e) {
                     $this->newLine();
                     $placeName = isset($place['displayName']['text']) ? $place['displayName']['text'] : 'Unknown';
                     $this->error("Lỗi khi xử lý địa điểm {$placeName}: " . $e->getMessage());
                 }
                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine();
            $this->info("Hoàn thành! Đã thêm thành công {$successCount}/" . count($places) . " địa điểm");

        } catch (\Exception $e) {
            $this->error('Có lỗi xảy ra: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Tìm kiếm địa điểm gần đó từ Google Maps API
     */
    private function searchNearbyPlaces($latitude, $longitude, $radius, $type, $limit)
    {
        $requestData = [
            'includedTypes' => [$type],
            'maxResultCount' => $limit,
            'locationRestriction' => [
                'circle' => [
                    'center' => [
                        'latitude' => (float) $latitude,
                        'longitude' => (float) $longitude
                    ],
                    'radius' => (float) $radius
                ]
            ]
        ];

        // Sử dụng OAuth service để gọi API
        $headers = [
            'X-Goog-FieldMask' => 'places.id,places.displayName,places.formattedAddress,places.location,places.rating,places.types,places.websiteUri,places.internationalPhoneNumber,places.photos,places.priceLevel'
        ];
        $response = $this->googleOAuth->makeApiRequest('POST', $this->placesApiUrl, $requestData, $headers);

        if (!$response->successful()) {
            throw new \Exception('Lỗi khi gọi Google Maps API: ' . $response->body());
        }

        $data = $response->json();
        return isset($data['places']) ? $data['places'] : [];
    }

    /**
     * Xử lý một địa điểm
     */
    private function processPlace($place, $wardId)
    {
        // Kiểm tra địa điểm đã tồn tại chưa
        $existingPlace = EntertainmentSpot::where('latitude', $place['location']['latitude'])
            ->where('longitude', $place['location']['longitude'])
            ->first();

        if ($existingPlace) {
            $this->newLine();
            $this->warn("Địa điểm {$place['displayName']['text']} đã tồn tại, bỏ qua");
            return false;
        }

        // Tải ảnh từ Google Maps (nếu có)
        $photos = $this->downloadPlacePhotos($place);

        // Tạo mô tả bằng ChatGPT
        $description = $this->generateDescription($place);

        // Lưu vào database
        $entertainmentSpot = EntertainmentSpot::create([
            'name' => isset($place['displayName']['text']) ? $place['displayName']['text'] : 'Unknown',
            'ward_id' => $wardId,
            'full_address' => isset($place['formattedAddress']) ? $place['formattedAddress'] : '',
            'phone_number' => isset($place['internationalPhoneNumber']) ? $place['internationalPhoneNumber'] : null,
            'description' => $description,
            'banner_image' => isset($photos[0]) ? $photos[0] : null, // Ảnh đầu tiên làm banner
            'price' => $this->getPriceFromPriceLevel(isset($place['priceLevel']) ? $place['priceLevel'] : null),
            'status' => 1, // Active
            'latitude' => $place['location']['latitude'],
            'longitude' => $place['location']['longitude'],
            'average_rating' => isset($place['rating']) ? $place['rating'] : 0,
            'additional_info' => json_encode([
                'google_place_id' => $place['id'],
                'website' => isset($place['websiteUri']) ? $place['websiteUri'] : null,
                'types' => isset($place['types']) ? $place['types'] : [],
                'photos' => $photos,
                'source' => 'google_maps',
                'imported_at' => now()->toISOString()
            ])
        ]);

        return true;
    }

    /**
     * Tải ảnh từ Google Maps
     */
    private function downloadPlacePhotos($place)
    {
        $photos = [];
        
        if (!isset($place['photos']) || empty($place['photos'])) {
            return $photos;
        }

        // Giới hạn tối đa 3 ảnh
        $photoReferences = array_slice($place['photos'], 0, 3);

        foreach ($photoReferences as $photo) {
            try {
                $photoUrl = $this->photosApiUrl . '/' . $place['id'] . '/photos/' . $photo['name'] . '/media?maxHeightPx=800';
                
                $response = $this->googleOAuth->makeApiRequest('GET', $photoUrl);
                
                if ($response->successful()) {
                    $filename = 'places/' . Str::uuid() . '.jpg';
                    Storage::disk('public')->put($filename, $response->body());
                    $photos[] = 'storage/' . $filename;
                }
            } catch (\Exception $e) {
                // Log lỗi nhưng không dừng quá trình
                $placeName = isset($place['displayName']['text']) ? $place['displayName']['text'] : 'Unknown';
                \Log::warning("Không thể tải ảnh cho địa điểm {$placeName}: " . $e->getMessage());
            }
        }

        return $photos;
    }

    /**
     * Tạo mô tả bằng ChatGPT
     */
    private function generateDescription($place)
    {
        try {
            $prompt = $this->buildPrompt($place);
            
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7
            ]);

            return isset($response->choices[0]->message->content) ? $response->choices[0]->message->content : 'Mô tả sẽ được cập nhật sau.';
        } catch (\Exception $e) {
            $placeName = isset($place['displayName']['text']) ? $place['displayName']['text'] : 'Unknown';
            \Log::warning("Không thể tạo mô tả cho địa điểm {$placeName}: " . $e->getMessage());
            return $this->generateFallbackDescription($place);
        }
    }

    /**
     * Tạo prompt cho ChatGPT
     */
    private function buildPrompt($place)
    {
        $name = isset($place['displayName']['text']) ? $place['displayName']['text'] : 'Unknown';
        $address = isset($place['formattedAddress']) ? $place['formattedAddress'] : '';
        $rating = isset($place['rating']) ? $place['rating'] : 'Chưa có đánh giá';
        $types = isset($place['types']) ? implode(', ', $place['types']) : '';
        $website = isset($place['websiteUri']) ? $place['websiteUri'] : 'Không có thông tin';

        return "Hãy viết một bài giới thiệu về địa điểm sau bằng tiếng Việt:

Tên: {$name}
Địa chỉ: {$address}
Loại hình: {$types}
Đánh giá: {$rating}/5
Website: {$website}

Yêu cầu:
- Viết bằng tiếng Việt
- Độ dài khoảng 150-250 từ
- Tập trung vào đặc điểm nổi bật và trải nghiệm của khách hàng
- Tone tích cực, thu hút, tự nhiên
- Không lặp lại thông tin đã có sẵn
- Tạo cảm giác muốn ghé thăm

Chỉ trả về nội dung mô tả, không cần tiêu đề hay format đặc biệt.";
    }

    /**
     * Tạo mô tả dự phòng khi ChatGPT không hoạt động
     */
    private function generateFallbackDescription($place)
    {
        $name = isset($place['displayName']['text']) ? $place['displayName']['text'] : 'địa điểm này';
        $address = isset($place['formattedAddress']) ? $place['formattedAddress'] : 'vị trí thuận lợi';
        
        return "Nằm tại {$address}, {$name} là một địa điểm thú vị đáng để khám phá. Với vị trí thuận lợi và không gian thoải mái, đây sẽ là lựa chọn tuyệt vời cho những ai muốn tìm kiếm trải nghiệm mới. Hãy ghé thăm để cảm nhận không khí sôi động và thưởng thức những gì đặc biệt mà nơi này mang lại.";
    }

    /**
     * Chuyển đổi price level thành giá ước tính
     */
    private function getPriceFromPriceLevel($priceLevel)
    {
        switch ($priceLevel) {
            case 'PRICE_LEVEL_FREE':
                return 'Miễn phí';
            case 'PRICE_LEVEL_INEXPENSIVE':
                return '50,000 - 150,000 VNĐ';
            case 'PRICE_LEVEL_MODERATE':
                return '150,000 - 300,000 VNĐ';
            case 'PRICE_LEVEL_EXPENSIVE':
                return '300,000 - 600,000 VNĐ';
            case 'PRICE_LEVEL_VERY_EXPENSIVE':
                return '600,000+ VNĐ';
            default:
                return 'Liên hệ';
        }
    }
} 