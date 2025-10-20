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
      return $this->model->latest()->paginate(15);
   }

   public function find(int $id): ?Product
   {
      return $this->model->findOrFail($id);
   }

   public function create(ProductData $data): Product
   {
      return $this->model->create($data->toArray());
   }

   public function update(int $id, ProductData $data): bool
   {
      $product = $this->find($id);
      return $product->update($data->toArray());
   }

   public function delete(int $id): bool
   {
      $product = $this->find($id);
      return $product->delete();
   }
}
