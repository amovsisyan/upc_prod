<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ProductVersion\Destroy;
use App\Http\Requests\Api\ProductVersion\Show;
use App\Http\Requests\Api\ProductVersion\Store;
use App\Http\Requests\Api\ProductVersion\Update;
use App\Services\ProductVersionService;
use App\Transformers\ProductVersionTransformer;
use Illuminate\Http\JsonResponse;


class ProductVersionController extends ApiController
{
    /**
     * @var ProductVersionService
     */
    private $productVersionService;

    /**
     * @var ProductVersionTransformer
     */
    private $productVersionTransformer;

    public function __construct
    (
        ProductVersionService $productVersionService,
        ProductVersionTransformer $productVersionTransformer
    )
    {
        $this->productVersionService = $productVersionService;
        $this->productVersionTransformer = $productVersionTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|null
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->productVersionService->getAll();

        return $this->respond($this->productVersionTransformer->transformCollection($collection));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        if ($new = $this->productVersionService
            ->store($request->only(array('product_id', 'brand_id', 'title', 'description', 'width', 'height', 'length', 'weight','active')))
        ) {
            return $this->respond($this->productVersionTransformer->transform($new));
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
        $id = $request->product_version;

        if ($model = $this->productVersionService->getById((int)$id)) {
            return $this->respond($this->productVersionTransformer->transform($model));
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
        $id = $request->product_version;

        if ($updated = $this->productVersionService
            ->updateById((int)$id, $request->only(array('product_id', 'brand_id', 'title', 'description', 'width', 'height', 'length', 'weight','active')))
        ) {
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
        $id = $request->product_version;

        if ($deleted = $this->productVersionService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
