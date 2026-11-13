<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportProvinceAndWardCommand extends Command
{
    // Mặc định lấy trực tiếp từ API v2 (đã là 2 cấp: tỉnh -> phường/xã).
    // Truyền đường dẫn file JSON nếu muốn import từ file đã tải sẵn.
    protected $signature = 'import:province-ward {file? : Đường dẫn file JSON 2 cấp; bỏ trống để tải từ API v2}';
    protected $description = 'Import tỉnh và phường/xã (cấu trúc 2 cấp) từ provinces.open-api.vn v2 hoặc từ file JSON';

    private const API_URL = 'https://provinces.open-api.vn/api/v2/?depth=2';

    public function handle()
    {
        $data = $this->loadData($this->argument('file'));
        if (!$data) {
            return self::FAILURE;
        }

        $provinceCount = 0;
        $wardCount = 0;

        try {
            DB::beginTransaction();

            foreach ($data as $province) {
                // updateOrInsert theo prefix (mã hành chính) để chạy lại không nhân đôi
                DB::table('tinh')->updateOrInsert(
                    ['prefix' => (string) $province['code']],
                    ['name' => $province['name'], 'slug' => Str::slug($province['name']), 'updated_at' => now(), 'created_at' => now()]
                );
                $provinceId = DB::table('tinh')->where('prefix', (string) $province['code'])->value('id');
                $provinceCount++;

                foreach ($province['wards'] ?? [] as $ward) {
                    DB::table('xa_phuong')->updateOrInsert(
                        ['prefix' => (string) $ward['code']],
                        ['name' => $ward['name'], 'slug' => Str::slug($ward['name']), 'province_id' => $provinceId, 'updated_at' => now(), 'created_at' => now()]
                    );
                    $wardCount++;
                }
            }

            DB::commit();
            $this->info("Import thành công: {$provinceCount} tỉnh, {$wardCount} phường/xã.");
            return self::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Lỗi: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    private function loadData(?string $file): ?array
    {
        if ($file) {
            if (!is_file($file)) {
                $this->error("Không tìm thấy file: {$file}");
                return null;
            }
            $this->info("Đọc từ file: {$file}");
            $data = json_decode(file_get_contents($file), true);
        } else {
            $this->info('Tải dữ liệu từ ' . self::API_URL);
            // verify tắt vì PHP local trên Windows thường thiếu CA bundle (API công khai)
            $response = Http::withoutVerifying()->timeout(60)->get(self::API_URL);
            if ($response->failed()) {
                $this->error('Gọi API thất bại, HTTP ' . $response->status());
                return null;
            }
            $data = $response->json();
        }

        if (!is_array($data) || !isset($data[0]['wards'])) {
            $this->error('JSON không đúng cấu trúc 2 cấp (mong đợi mảng tỉnh, mỗi tỉnh có "wards").');
            return null;
        }
        return $data;
    }
}
