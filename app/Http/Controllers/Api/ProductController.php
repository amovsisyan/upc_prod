<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Product\Destroy;
use App\Http\Requests\Api\Product\Show;
use App\Http\Requests\Api\Product\Store;
use App\Http\Requests\Api\Product\Update;
use App\Services\ProductService;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
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
        $productCollection = $this->productService->getAll();

        return $this->respond($this->productTransformer->transformCollection($productCollection));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        $structuredStoreData = array(
            'upc' => $request->upc,
        );

        if ($newProduct = $this->productService->store($structuredStoreData)) {
            return $this->respond($this->productTransformer->transform($newProduct));
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

        if ($product = $this->productService->getById((int)$id)) {
            return $this->respond($this->productTransformer->transform($product));
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
        $structuredUpdateData = array(
            'upc' => $request->upc
        );

        if ($updatedProduct = $this->productService->updateById((int)$id, $structuredUpdateData)) {
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
