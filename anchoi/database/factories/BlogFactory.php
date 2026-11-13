<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        // slug tự sinh trong Model::boot() từ title
        return [
            'title' => rtrim($this->faker->sentence(random_int(6, 10)), '.'),
            'body' => $this->fakeBody(),
            'banner_image' => null, // để placeholder; upload ảnh thật qua Nova sau
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }

    /** Sinh nội dung HTML nhiều đoạn, giống bài blog thật. */
    private function fakeBody(): string
    {
        $html = '<p>' . $this->faker->paragraph(8) . '</p>';
        foreach (range(1, random_int(3, 5)) as $i) {
            $html .= '<h2>' . rtrim($this->faker->sentence(5), '.') . '</h2>';
            $html .= '<p>' . $this->faker->paragraph(10) . '</p>';
            $html .= '<p>' . $this->faker->paragraph(6) . '</p>';
        }
        return $html;
    }
}
