<?php

namespace Modules\Category\Services;

use Illuminate\Support\Collection;
use Modules\Category\Data\CategoryData;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
   public function __construct(protected CategoryRepositoryInterface $categoryRepository)
   {
   }

   public function getAllCategories(): Collection
   {
      return $this->categoryRepository->all();
   }

   public function createNewCategory(CategoryData $data): Category
   {
      return $this->categoryRepository->create($data);
   }

   public function updateCategory(int $id, CategoryData $data): bool
   {
      return $this->categoryRepository->update($id, $data);
   }

   public function deleteCategory(int $id): bool
   {
      return $this->categoryRepository->delete($id);
   }
}
