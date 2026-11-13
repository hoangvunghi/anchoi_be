<?php

namespace App\Console\Commands;

use App\Models\EntertainmentSpot;
use App\Models\Ward;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportLocationFromJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'location:import-from-json 
                            {--file=location.json : Đường dẫn file JSON}
                            {--ward-id= : ID của phường/xã để gán cho địa điểm}
                            {--download-photos : Có tải ảnh từ Google hay không}';

    /**
     * The console command description.
     */
    protected $description = 'Import địa điểm từ file JSON (từ Google Places API) vào database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->option('file');
        $wardId = $this->option('ward-id') ?: $this->ask('Nhập Ward ID');
        $downloadPhotos = $this->option('download-photos');

        if (!$wardId) {
            $this->error('Vui lòng nhập Ward ID');
            return 1;
        }

        // Kiểm tra ward có tồn tại không
        $ward = Ward::find($wardId);
        if (!$ward) {
            $this->error("Không tìm thấy Ward với ID: {$wardId}");
            return 1;
        }

        // Đọc file JSON
        if (!file_exists($filePath)) {
            $this->error("Không tìm thấy file: {$filePath}");
            return 1;
        }

        $this->info("📂 Đọc file: {$filePath}");
        $this->info("📍 Ward: {$ward->full_name}");

        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);

        if (!$data || !isset($data['places'])) {
            $this->error('File JSON không hợp lệ hoặc không có dữ liệu places');
            return 1;
        }

        $places = $data['places'];
        $this->info("🎯 Tìm thấy " . count($places) . " địa điểm để import");

        if ($downloadPhotos) {
            $this->info("📸 Sẽ tải ảnh từ Google Photos");
        } else {
            $this->warn("📸 Bỏ qua tải ảnh (sử dụng --download-photos để bật)");
        }

        // Progress bar
        $progressBar = $this->output->createProgressBar(count($places));
        $progressBar->start();

        $successCount = 0;
        $skipCount = 0;
        $errorCount = 0;

        foreach ($places as $place) {
            try {
                $result = $this->processPlace($place, $wardId, $downloadPhotos);
                
                if ($result === 'success') {
                    $successCount++;
                } elseif ($result === 'skip') {
                    $skipCount++;
                }
            } catch (\Exception $e) {
                $errorCount++;
                $placeName = $this->getPlaceName($place);
                $errorMessage = "Lỗi khi import địa điểm {$placeName}: " . $e->getMessage();
                \Log::error($errorMessage);
                $this->newLine();
                $this->error("❌ {$errorMessage}");
                $this->error("📍 File: " . $e->getFile() . " - Line: " . $e->getLine());
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        // Báo cáo kết quả
        $this->info("✅ Hoàn thành import!");
        $this->table(['Kết quả', 'Số lượng'], [
            ['Thành công', $successCount],
            ['Bỏ qua (đã tồn tại)', $skipCount],
            ['Lỗi', $errorCount],
            ['Tổng cộng', count($places)]
        ]);

        return 0;
    }

    /**
     * Xử lý một địa điểm
     */
    private function processPlace($place, $wardId, $downloadPhotos)
    {
        // Lấy thông tin cơ bản
        $placeName = $this->getPlaceName($place);
        $latitude = $place['location']['latitude'] ?? null;
        $longitude = $place['location']['longitude'] ?? null;

        if (!$latitude || !$longitude) {
            $this->newLine();
            $this->warn("Bỏ qua {$placeName}: Không có tọa độ");
            return 'skip';
        }

        // Kiểm tra địa điểm đã tồn tại chưa (theo tọa độ)
        $existingPlace = EntertainmentSpot::where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->first();

        if ($existingPlace) {
            return 'skip';
        }

        // Kiểm tra theo Google Place ID nếu có
        $googlePlaceId = $place['id'] ?? null;
        if ($googlePlaceId) {
            $existingByPlaceId = EntertainmentSpot::whereJsonContains('additional_info->google_place_id', $googlePlaceId)->first();
            if ($existingByPlaceId) {
                return 'skip';
            }
        }

        // Tải ảnh nếu được yêu cầu
        $photos = [];
        if ($downloadPhotos && isset($place['photos'])) {
            $photos = $this->downloadPlacePhotos($place);
        }

        // Chuẩn bị dữ liệu
        $data = [
            'name' => $placeName,
            'entertainment_type_id' => $this->getEntertainmentTypeId($place),
            'ward_id' => $wardId,
            'full_address' => $place['formattedAddress'] ?? '',
            'phone_number' => $this->getPhoneNumber($place),
            'description' => $this->generateBasicDescription($place),
            'banner_image' => isset($photos[0]) ? $photos[0] : null,
            'price' => $this->getPriceFromPlace($place),
            'status' => 'approved', // app lọc where('status','approved'); ghi 1 thì spot bị ẩn
            'latitude' => $latitude,
            'longitude' => $longitude,
            'average_rating' => $place['rating'] ?? 0,
            'additional_info' => json_encode([
                'google_place_id' => $googlePlaceId,
                'website' => $place['websiteUri'] ?? null,
                'google_maps_uri' => $place['googleMapsUri'] ?? null,
                'types' => $place['types'] ?? [],
                'photos' => $photos,
                'phone_international' => $place['internationalPhoneNumber'] ?? null,
                'phone_national' => $place['nationalPhoneNumber'] ?? null,
                'business_status' => $place['businessStatus'] ?? null,
                'user_rating_count' => $place['userRatingCount'] ?? 0,
                'opening_hours' => $this->getOpeningHours($place),
                'services' => $this->getServices($place),
                'source' => 'json_import',
                'imported_at' => now()->toISOString()
            ])
        ];

        // Lưu vào database
        EntertainmentSpot::create($data);

        return 'success';
    }

    /**
     * Lấy tên địa điểm
     */
    private function getPlaceName($place)
    {
        if (isset($place['displayName']['text'])) {
            return $place['displayName']['text'];
        }
        
        return 'Unknown Place';
    }

    /**
     * Lấy số điện thoại
     */
    private function getPhoneNumber($place)
    {
        // Ưu tiên số quốc tế, fallback về số quốc gia
        return $place['internationalPhoneNumber'] ?? $place['nationalPhoneNumber'] ?? null;
    }

    /**
     * Tạo mô tả cơ bản từ dữ liệu có sẵn
     */
    private function generateBasicDescription($place)
    {
        $name = $this->getPlaceName($place);
        $address = $place['formattedAddress'] ?? '';
        $types = $place['types'] ?? [];
        
        // Loại bỏ các type generic
        $meaningfulTypes = array_filter($types, function($type) {
            return !in_array($type, ['establishment', 'point_of_interest']);
        });
        
        $typeText = '';
        if (!empty($meaningfulTypes)) {
            $typeText = ' Đây là ' . implode(', ', array_slice($meaningfulTypes, 0, 2));
        }
        
        return "{$name} tọa lạc tại {$address}.{$typeText}. Địa điểm này sẽ mang đến cho bạn những trải nghiệm thú vị và đáng nhớ.";
    }

    /**
     * Lấy thông tin giá từ dữ liệu
     */
    private function getPriceFromPlace($place)
    {
        // Google Places API có thể có priceLevel (0-4)
        // 0: Free, 1: Inexpensive, 2: Moderate, 3: Expensive, 4: Very Expensive
        $priceLevel = $place['priceLevel'] ?? null;
        
        if ($priceLevel !== null) {
            // Convert price level to approximate VND (example mapping)
            $priceMapping = [
                0 => 0,      // Free
                1 => 50000,  // 50k VND
                2 => 150000, // 150k VND  
                3 => 300000, // 300k VND
                4 => 500000, // 500k VND
            ];
            
            return $priceMapping[$priceLevel] ?? 100000;
        }
        
        // Mặc định 100k VND nếu không có thông tin
        return 100000;
    }

    /**
     * Lấy giờ mở cửa
     */
    private function getOpeningHours($place)
    {
        $hours = [];
        
        if (isset($place['regularOpeningHours']['weekdayDescriptions'])) {
            $hours['weekday_descriptions'] = $place['regularOpeningHours']['weekdayDescriptions'];
        }
        
        if (isset($place['regularOpeningHours']['openNow'])) {
            $hours['open_now'] = $place['regularOpeningHours']['openNow'];
        }
        
        return $hours;
    }

    /**
     * Lấy thông tin dịch vụ
     */
    private function getServices($place)
    {
        $services = [];
        
        // Các dịch vụ có thể có
        $serviceFields = ['takeout', 'delivery', 'dineIn', 'curbsidePickup', 'restroom'];
        
        foreach ($serviceFields as $field) {
            if (isset($place[$field])) {
                $services[$field] = $place[$field];
            }
        }
        
        return $services;
    }

    /**
     * Xác định entertainment_type_id dựa trên Google Place types
     */
    private function getEntertainmentTypeId($place)
    {
        $types = $place['types'] ?? [];
        
        // Mapping Google Place types với entertainment types từ database
        // 1: Karaoke, 2: Bar, 3: Nhà hàng, 4: Club
        $typeMapping = [
            'karaoke' => 1,
            'night_club' => 4,
            'bar' => 2,
            'restaurant' => 3,
            'cafe' => 3,
            'food' => 3,
            'meal_takeaway' => 3,
            'bakery' => 3,
            'casino' => 4,
        ];
        
        // Tìm type đầu tiên khớp với mapping
        foreach ($types as $type) {
            if (isset($typeMapping[$type])) {
                return $typeMapping[$type];
            }
        }
        
        // Mặc định trả về 3 (nhà hàng) nếu không tìm thấy
        return 3;
    }

    /**
     * Tải ảnh từ Google Photos
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
                // Tạo URL ảnh từ photo name
                $photoName = $photo['name'] ?? '';
                if (empty($photoName)) {
                    continue;
                }

                // Google Photos API URL
                $photoUrl = "https://places.googleapis.com/v1/{$photoName}/media?maxHeightPx=800&key=" . config('services.google_maps.api_key');
                
                $response = Http::timeout(30)->get($photoUrl);
                
                if ($response->successful()) {
                    $filename = 'places/' . Str::uuid() . '.jpg';
                    Storage::disk('public')->put($filename, $response->body());
                    $photos[] = 'storage/' . $filename;
                }
            } catch (\Exception $e) {
                $placeName = $this->getPlaceName($place);
                \Log::warning("Không thể tải ảnh cho địa điểm {$placeName}: " . $e->getMessage());
            }
        }

        return $photos;
    }
} 