<?php

namespace Modules\Product\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Data\ProductData;
use Modules\Product\Http\Requests\V1\StoreProductRequest;
use Modules\Product\Http\Requests\V1\UpdateProductRequest;
use Modules\Product\Http\Resources\V1\ProductResource;
use Modules\Product\Models\Product;
use Modules\Product\Services\ProductService;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for Products"
 * )
 */
class ProductController extends Controller
{

   public function __construct(protected ProductService $productService)
   {
   }

   /**
    * @OA\Get(
    *     path="/api/v1/products",
    *     summary="Get list of all products",
    *     tags={"Products"},
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/ProductResource")
    *         )
    *     )
    * )
    */
   public function index()
   {
      $products = $this->productService->getAllProducts();
      return ProductResource::collection($products);
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create()
   {
      return view('product::create');
   }

   /**
    * @OA\Post(
    *     path="/api/v1/products",
    *     summary="Create a new product",
    *     tags={"Products"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Product created successfully",
    *         @OA\JsonContent(ref="#/components/schemas/ProductResource")
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function store(StoreProductRequest $request): JsonResponse
   {
      $productData = ProductData::from($request->validated());

      $product = $this->productService->createNewProduct($productData);

      return (new ProductResource($product))
         ->response()
         ->setStatusCode(Response::HTTP_CREATED);
   }

   /**
    * @OA\Get(
    *     path="/api/v1/products/{id}",
    *     summary="Get a specific product by ID",
    *     tags={"Products"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Product ID",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/ProductResource")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Product not found"
    *     )
    * )
    */
   public function show(Product $product): JsonResource
   {
      // $foundProduct = $this->productService->getProductById($product->id);
      return new ProductResource($product);
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit($id)
   {
      return view('product::edit');
   }

   /**
    * @OA\Put(
    *     path="/api/v1/products/{id}",
    *     summary="Update an existing product",
    *     tags={"Products"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Product ID",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Product updated successfully",
    *         @OA\JsonContent(ref="#/components/schemas/ProductResource")
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Product not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Validation error"
    *     )
    * )
    */
   public function update(UpdateProductRequest $request, Product $product): JsonResource
   {
      $productData = ProductData::from($request->validated());

      $this->productService->updateProduct($product->id, $productData);

      return new ProductResource($product->fresh(['categories']));
   }

   /**
    * @OA\Delete(
    *     path="/api/v1/products/{id}",
    *     summary="Delete a product",
    *     tags={"Products"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Product ID",
    *         required=true,
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="Product deleted successfully"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Product not found"
    *     )
    * )
    */
   public function destroy(Product $product): JsonResponse
   {
      $this->productService->deleteProduct($product->id);

      return response()->json(null, Response::HTTP_NO_CONTENT);
   }
}
