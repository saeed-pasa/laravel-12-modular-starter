<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Models\Category;

class CategoryFactory extends Factory
{
   /**
    * The name of the factory's corresponding model.
    */
   protected $model = Category::class;

   /**
    * Define the model's default state.
    */
   public function definition(): array
   {
      return [
         'name' => $this->faker->unique()->word,
      ];
   }
}

