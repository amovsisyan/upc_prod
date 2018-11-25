<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Product\Destroy;
use App\Http\Requests\Api\Product\Show;
use App\Http\Requests\Api\Product\Store;
use App\Http\Requests\Api\Product\Update;
use App\Http\Requests\Api\Product\UpdateCategory;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct
    (
        ProductService $productService
    )
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->productService->getAll();

        return $this->respond($collection->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        if ($new = $this->productService->store($request->only(
            [
                'upc',
                'categories', 'subCategories', // for category, subcategory part
                'images', 'videos', // for attachment part
                'brand_id', 'title', 'description', 'width', 'height', 'length', 'weight' // for product version part
            ]
        ))) {
            return $this->respond($new->toArray());
        }

        return $this->respondInternalError();
    }

    /**
     * Display the specified resource.
     *
     * @param Show $request
     * @return JsonResponse|null
     */
    public function show(Show $request): ?JsonResponse
    {
        $id = $request->product;
        $with = !empty($request->only('with')) ? array_values($request->only('with')) : array();

        if ($model = $this->productService->getById((int)$id, $with)) {
            return $this->respond($model->toArray());
        }

        return $this->respondInternalError();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Update $request
     * @return JsonResponse|null
     */
    public function update(Update $request): ?JsonResponse
    {
        $id = $request->product;

        if ($updated = $this->productService->updateById((int)$id, $request->only(['upc']))) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }

    /**
     * @param UpdateCategory $request
     * @return JsonResponse|null
     */
    public function updateCategory(UpdateCategory $request): ?JsonResponse
    {
        $id = $request->product;

        if ($updated = $this->productService->updateCategoriesById((int)$id, $request->only(['categories', 'subCategories']))) {
            return $this->respond($updated->toArray());
        }

        return $this->respondInternalError();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Destroy $request
     * @return JsonResponse|null
     * @throws \Exception
     */
    public function destroy(Destroy $request): ?JsonResponse
    {
        $id = $request->product;

        if ($deleted = $this->productService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
