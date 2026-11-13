<?php

namespace App\Console\Commands;

use App\Models\Ward;
use App\Models\Province;
use Illuminate\Console\Command;

class ListWardsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'location:list-wards 
                            {--province= : Tên hoặc ID tỉnh để lọc}
                            {--search= : Tìm kiếm theo tên ward}
                            {--limit=20 : Số lượng kết quả hiển thị}';

    /**
     * The console command description.
     */
    protected $description = 'Liệt kê các ward ID để sử dụng khi import địa điểm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provinceFilter = $this->option('province');
        $searchTerm = $this->option('search');
        $limit = $this->option('limit');

        $query = Ward::with('province');

        // Lọc theo tỉnh
        if ($provinceFilter) {
            if (is_numeric($provinceFilter)) {
                $query->where('province_id', $provinceFilter);
            } else {
                $query->whereHas('province', function($q) use ($provinceFilter) {
                    $q->where('name', 'LIKE', "%{$provinceFilter}%");
                });
            }
        }

        // Tìm kiếm theo tên ward
        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $wards = $query->orderBy('province_id')->orderBy('name')->limit($limit)->get();

        if ($wards->isEmpty()) {
            $this->warn('Không tìm thấy ward nào phù hợp với điều kiện tìm kiếm');
            return 0;
        }

        // Hiển thị bảng kết quả
        $headers = ['Ward ID', 'Tên Ward', 'Tỉnh/Thành phố', 'Province ID'];
        $rows = [];

        foreach ($wards as $ward) {
            $rows[] = [
                $ward->id,
                $ward->name,
                $ward->province ? $ward->province->name : 'N/A',
                $ward->province_id
            ];
        }

        $this->table($headers, $rows);

        $this->info("\nSử dụng Ward ID ở cột đầu tiên để import địa điểm:");
        $this->line("php artisan location:import-from-google-maps --lat=10.762622 --lng=106.660172 --ward-id={$wards->first()->id}");

        // Hiển thị thông tin tổng quan
        $this->newLine();
        $this->info("Tổng số ward hiển thị: " . $wards->count());
        
        if ($wards->count() >= $limit) {
            $this->warn("Kết quả bị giới hạn ở {$limit} bản ghi. Sử dụng --limit để thay đổi hoặc --search để lọc kết quả.");
        }

        return 0;
    }
} 