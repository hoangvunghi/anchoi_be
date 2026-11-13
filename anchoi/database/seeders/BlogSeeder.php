<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Chỉ chạy ở local — tránh đổ dữ liệu mẫu lên production
        if (!app()->environment('local')) {
            $this->command->warn('BlogSeeder chỉ chạy ở môi trường local. Bỏ qua.');
            return;
        }

        $categories = collect(['Ẩm thực', 'Giải trí', 'Review địa điểm', 'Cẩm nang đi chơi', 'Tin tức'])
            ->map(fn ($name) => Category::firstOrCreate(['name' => $name]));

        Blog::factory(12)->create();

        $this->command->info('Đã seed ' . $categories->count() . ' danh mục + 12 bài blog (local).');
    }
}
