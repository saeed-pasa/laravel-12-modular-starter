<?php

namespace Modules\Category\Repositories\Contracts;

use Illuminate\Support\Collection;
use Modules\Category\Data\CategoryData;
use Modules\Category\Models\Category;

interface CategoryRepositoryInterface
{
   public function all(): Collection;

   public function find(int $id): ?Category;

   public function create(CategoryData $data): Category;

   public function update(int $id, CategoryData $data): bool;

   public function delete(int $id): bool;
}
