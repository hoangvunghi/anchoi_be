<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportProvinceAndWardCommand extends Command
{
    protected $signature = 'import:province-ward';
    protected $description = 'Import dữ liệu tỉnh và phường/xã từ file a.json';

    public function handle()
    {
        // Đọc file JSON
        $jsonData = file_get_contents(base_path("a.json"));
        $data = json_decode($jsonData, true);

        try {
            DB::beginTransaction();

            foreach ($data as $province) {
                // Insert tỉnh
                $provinceId = DB::table('tinh')->insertGetId([
                    'name' => $province['name'],
                    'slug' => Str::slug($province['name']),
                    'prefix' => $province['code'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Insert ward trực tiếp vào tỉnh
                foreach ($province['districts'] as $district) {
                    foreach ($district['wards'] as $ward) {
                        DB::table('xa_phuong')->insert([
                            'name' => $ward['name'],
                            'slug' => Str::slug($ward['name']),
                            'prefix' => $ward['code'],
                            'province_id' => $provinceId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            DB::commit();
            $this->info('Import dữ liệu thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Lỗi: ' . $e->getMessage());
        }
    }
} 