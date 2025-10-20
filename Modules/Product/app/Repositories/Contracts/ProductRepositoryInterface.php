<?php

namespace Modules\Product\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Product\Data\ProductData;
use Modules\Product\Models\Product;

interface ProductRepositoryInterface
{
   public function all(): LengthAwarePaginator;

   public function find(int $id): ?Product;

   public function create(ProductData $data): Product;

   public function update(int $id, ProductData $data): bool;

   public function delete(int $id): bool;
}
