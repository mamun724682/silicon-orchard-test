<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    /**
     * @route /api/v1/products
     * @method Get
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->success(
            'List of products',
            ProductResource::collection($this->productService->getPaginate('user'))->response()->getData()
        );
    }

    /**
     * @route /api/v1/products
     * @method Post
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        return response()->success(
            'Product created successfully.',
            new ProductResource($this->productService->storeOrUpdate($request->validated() + ['user_id' => auth()->id()])),
            Response::HTTP_CREATED
        );
    }

    /**
     * @route /api/v1/products/{id}
     * @method Get
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->success(
            'Product show.',
            new ProductResource($this->productService->get($id, 'user'))
        );
    }

    /**
     * @route /api/v1/products/{id}
     * @method Put|Patch
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        return response()->success(
            'Product updated successfully.',
            new ProductResource($this->productService->storeOrUpdate($request->validated(), $id)),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @route /api/v1/products/{id}
     * @method Delete
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->productService->delete($id);

        // remove from

        return response()->success('Product deleted successfully.');
    }
}
