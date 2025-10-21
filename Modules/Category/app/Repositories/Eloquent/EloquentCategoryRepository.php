<?php

namespace Modules\Category\Repositories\Eloquent;


use Illuminate\Support\Collection;
use Modules\Category\Data\CategoryData;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\Contracts\CategoryRepositoryInterface;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{

   public function __construct(protected Category $model)
   {
   }

   public function all(): Collection
   {
      return $this->model->latest()->get();
   }

   public function find(int $id): ?Category
   {
      return $this->model->findOrFail($id);
   }

   public function create(CategoryData $data): Category
   {
      return $this->model->create($data->toArray());
   }

   public function update(int $id, CategoryData $data): bool
   {
      $category = $this->find($id);
      return $category->update($data->toArray());
   }

   public function delete(int $id): bool
   {
      $category = $this->find($id);
      return $category->delete();
   }
}
