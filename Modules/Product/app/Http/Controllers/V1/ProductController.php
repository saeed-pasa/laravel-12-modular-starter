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

class ProductController extends Controller
{

   public function __construct(protected ProductService $productService)
   {
   }

   /**
    * Display a listing of the resource.
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
    * Store a newly created resource in storage.
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
    * Show the specified resource.
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
    * Update the specified resource in storage.
    */
   public function update(UpdateProductRequest $request, Product $product): JsonResource
   {
      $productData = ProductData::from($request->validated());

      $this->productService->updateProduct($product->id, $productData);

      return new ProductResource($product->fresh());
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Product $product): JsonResponse
   {
      $this->productService->deleteProduct($product->id);

      return response()->json(null, Response::HTTP_NO_CONTENT);
   }
}
