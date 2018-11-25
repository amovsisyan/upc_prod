<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ProductVersion\Destroy;
use App\Http\Requests\Api\ProductVersion\Show;
use App\Http\Requests\Api\ProductVersion\Store;
use App\Http\Requests\Api\ProductVersion\Update;
use App\Services\ProductVersionService;
use Illuminate\Http\JsonResponse;


class ProductVersionController extends ApiController
{
    /**
     * @var ProductVersionService
     */
    private $productVersionService;

    public function __construct
    (
        ProductVersionService $productVersionService
    )
    {
        $this->productVersionService = $productVersionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|null
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->productVersionService->getAll();

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
        if ($new = $this->productVersionService
            ->store($request->only(array('product_id', 'brand_id', 'title', 'description', 'width', 'height', 'length', 'weight','active')))
        ) {
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
        $id = $request->product_version;
        $with = !empty($request->only('with')) ? array_values($request->only('with')) : array();

        if ($model = $this->productVersionService->getById((int)$id, $with)) {
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
        $id = $request->product_version;

        if ($updated = $this->productVersionService
            ->makeVersionById((int)$id, $request->only(array('product_id', 'brand_id', 'title', 'description', 'width', 'height', 'length', 'weight','active')))
        ) {
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
        $id = $request->product_version;

        if ($deleted = $this->productVersionService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
