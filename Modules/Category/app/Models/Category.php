<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Category\Database\Factories\CategoryFactory;
use Modules\Product\Models\Product;

class Category extends Model
{
   use HasFactory;

   protected $fillable = ['name'];


   public function products(): BelongsToMany
   {
      return $this->belongsToMany(Product::class, 'category_product');
   }

   protected static function newFactory(): CategoryFactory
   {
      return CategoryFactory::new();
   }
}
