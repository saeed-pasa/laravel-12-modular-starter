<?php

namespace Modules\Product\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Product\Data\ProductData;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
   public function __construct(
      protected ProductRepositoryInterface $productRepository
   )
   {
   }

   public function getAllProducts(): LengthAwarePaginator
   {
      return $this->productRepository->all();
   }

   public function getProductById(int $id): ?Product
   {
      return $this->productRepository->find($id);
   }

   public function createNewProduct(ProductData $data): Product
   {
      // **منطق تجاری می‌تواند اینجا باشد**
      // مثلا:
      // if ($data->price > 1000000) {
      //     // notify admin
      // }

      return $this->productRepository->create($data);
   }

   public function updateProduct(int $id, ProductData $data): bool
   {
      return $this->productRepository->update($id, $data);
   }

   public function deleteProduct(int $id): bool
   {
      // **منطق تجاری می‌تواند اینجا باشد**
      // مثلا:
      // $product = $this->productRepository->find($id);
      // $this->logDeletion($product);

      return $this->productRepository->delete($id);
   }
}
