<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        // slug tự sinh trong Model::boot() từ name
        return [
            'name' => ucfirst($this->faker->unique()->words(2, true)),
        ];
    }
}
