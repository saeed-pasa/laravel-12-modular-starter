<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Product\Database\Factories\ProductFactory;
use Modules\Category\Models\Category;

class Product extends Model
{
   use HasFactory;

   /**
    * The attributes that are mass assignable.
    */
   protected $fillable = [
      'name',
      'description',
      'price',
   ];

   public function categories(): BelongsToMany
   {
      return $this->belongsToMany(Category::class, 'category_product');
   }

   protected static function newFactory(): ProductFactory
   {
      return ProductFactory::new();
   }
}
