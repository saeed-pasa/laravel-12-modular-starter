<?php

namespace Modules\Category\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Category\Data\CategoryData;
use Modules\Category\Http\Requests\V1\StoreCategoryRequest;
use Modules\Category\Http\Requests\V1\UpdateCategoryRequest;
use Modules\Category\Http\Resources\V1\CategoryResource;
use Modules\Category\Models\Category;
use Modules\Category\Services\CategoryService;

class CategoryController extends Controller
{
   public function __construct(protected CategoryService $categoryService)
   {
   }

   /**
    * @OA\Get(
    * path="/api/v1/categories",
    * summary="دریافت لیست همه‌ی دسته‌بندی‌ها",
    * tags={"Categories"},
    * security={{"bearerAuth":{}}},
    * @OA\Response(
    * response=200,
    * description="لیست دسته‌بندی‌ها",
    * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CategoryResponse"))
    * ),
    * @OA\Response(response=401, description="Unauthenticated"),
    * @OA\Response(response=403, description="Forbidden (نیاز به 'view categories')")
    * )
    */
   public function index(): JsonResource
   {
      $categories = $this->categoryService->getAllCategories();
      return CategoryResource::collection($categories);
   }

   /**
    * @OA\Post(
    * path="/api/v1/categories",
    * summary="ایجاد دسته‌بندی جدید",
    * tags={"Categories"},
    * security={{"bearerAuth":{}}},
    * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CategoryRequest")),
    * @OA\Response(response=201, description="ایجاد موفق", @OA\JsonContent(ref="#/components/schemas/CategoryResourceWrapped")),
    * @OA\Response(response=403, description="Forbidden (نیاز به 'create categories')"),
    * @OA\Response(response=422, description="Validation Error")
    * )
    */
   public function store(StoreCategoryRequest $request): JsonResponse
   {
      $categoryData = CategoryData::from($request->validated());
      $category = $this->categoryService->createNewCategory($categoryData);

      return (new CategoryResource($category))
         ->response()
         ->setStatusCode(Response::HTTP_CREATED);
   }

   /**
    * @OA\Get(
    * path="/api/v1/categories/{category}",
    * summary="دریافت جزئیات یک دسته‌بندی",
    * tags={"Categories"},
    * security={{"bearerAuth":{}}},
    * @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="integer")),
    * @OA\Response(response=200, description="موفق", @OA\JsonContent(ref="#/components/schemas/CategoryResourceWrapped")),
    * @OA\Response(response=403, description="Forbidden (نیاز به 'view categories')"),
    * @OA\Response(response=404, description="Not Found")
    * )
    */
   public function show(Category $category): JsonResource
   {
      // Route Model Binding به صورت خودکار findOrFail را انجام می‌دهد
      return new CategoryResource($category);
   }

   /**
    * @OA\Put(
    * path="/api/v1/categories/{category}",
    * summary="به‌روزرسانی یک دسته‌بندی",
    * tags={"Categories"},
    * security={{"bearerAuth":{}}},
    * @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="integer")),
    * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CategoryRequest")),
    * @OA\Response(response=200, description="موفق", @OA\JsonContent(ref="#/components/schemas/CategoryResourceWrapped")),
    * @OA\Response(response=403, description="Forbidden (نیاز به 'edit categories')"),
    * @OA\Response(response=404, description="Not Found"),
    * @OA\Response(response=422, description="Validation Error")
    * )
    */
   public function update(UpdateCategoryRequest $request, Category $category): JsonResource
   {
      $categoryData = CategoryData::from($request->validated());
      $this->categoryService->updateCategory($category->id, $categoryData);

      return new CategoryResource($category->fresh());
   }

   /**
    * @OA\Delete(
    * path="/api/v1/categories/{category}",
    * summary="حذف یک دسته‌بندی",
    * tags={"Categories"},
    * security={{"bearerAuth":{}}},
    * @OA\Parameter(name="category", in="path", required=true, @OA\Schema(type="integer")),
    * @OA\Response(response=204, description="حذف موفق (No Content)"),
    * @OA\Response(response=403, description="Forbidden (نیاز به 'delete categories')"),
    * @OA\Response(response=404, description="Not Found")
    * )
    */
   public function destroy(Category $category): JsonResponse
   {
      // بررسی دسترسی اضافی (می‌توان در Route هم گذاشت)
      if (!Auth::guard('api')->user()->can('delete categories')) {
         abort(403);
      }

      $this->categoryService->deleteCategory($category->id);
      return response()->json(null, Response::HTTP_NO_CONTENT);
   }
}
