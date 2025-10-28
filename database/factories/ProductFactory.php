<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\Category;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
         'category_id' => Category::inRandomOrder()->first()->id,
         'name' => $this->faker->word(),
         'description' => $this->faker->paragraph(),
         'price' => rand(1000, 99999)
        ];
    }
}
