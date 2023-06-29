<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use FakerRestaurant\Provider\en_US\Restaurant;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Restaurant($faker));

        return [
            'title' => $faker->vegetableName(),
            'slug' => $faker->slug,
            'category_id' => $faker->numberBetween(1, 2),
            'price' => $faker->numberBetween(100, 1000),
            'stock' => $faker->numberBetween(0, 100),
            'description' => $faker->paragraph,
            'image' => null,
        ];
    }
}
