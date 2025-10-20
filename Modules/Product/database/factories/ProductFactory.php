<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

class ProductFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    */
   protected $model = Product::class;

   /**
    * Define the model's default state.
    */
   public function definition(): array
   {
      return [
         'name' => $this->faker->commerce->productName(),
         'description' => $this->faker->paragraph,
         'price' => $this->faker->numberBetween(100000, 5000000),
      ];
   }
}

