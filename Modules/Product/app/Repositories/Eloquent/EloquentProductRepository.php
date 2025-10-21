<?php

namespace Modules\Product\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Product\Data\ProductData;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\Contracts\ProductRepositoryInterface;

class EloquentProductRepository implements ProductRepositoryInterface
{

   public function __construct(
      protected Product $model
   )
   {
   }

   public function all(): LengthAwarePaginator
   {
      return $this->model->with('categories')->latest()->paginate(15);
   }

   public function find(int $id): ?Product
   {
      return $this->model->with('categories')->findOrFail($id);
   }

   public function create(ProductData $data): Product
   {
      $product = $this->model->create($data->except('category_ids')->toArray());

      if (isset($data->category_ids)) {
         $product->categories()->sync($data->category_ids ?? []);
      }

      return $product->load('categories');
   }

   public function update(int $id, ProductData $data): bool
   {
      $product = $this->find($id);

      $updateResult = $product->update($data->except('category_ids')->toArray());

      if (isset($data->category_ids)) {
         $product->categories()->sync($data->category_ids ?? []);
      }

      return $updateResult;
   }

   public function delete(int $id): bool
   {
      $product = $this->find($id);
      return $product->delete();
   }
}
