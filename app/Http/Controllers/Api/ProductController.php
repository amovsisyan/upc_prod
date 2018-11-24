<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Product\Destroy;
use App\Http\Requests\Api\Product\Show;
use App\Http\Requests\Api\Product\Store;
use App\Http\Requests\Api\Product\Update;
use App\Services\ProductService;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var ProductTransformer
     */
    private $productTransformer;

    public function __construct
    (
        ProductService $productService,
        ProductTransformer $productTransformer
    )
    {
        $this->productService = $productService;
        $this->productTransformer = $productTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->productService->getAll();

        return $this->respond($this->productTransformer->transformCollection($collection));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        if ($new = $this->productService->store($request->only(['upc']))) {
            return $this->respond($this->productTransformer->transform($new));
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

        if ($model = $this->productService->getById((int)$id)) {
            return $this->respond($this->productTransformer->transform($model));
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
