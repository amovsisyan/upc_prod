<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Brands\Destroy;
use App\Http\Requests\Api\Brands\Show;
use App\Http\Requests\Api\Brands\Store;
use App\Http\Requests\Api\Brands\Update;
use App\Services\BrandService;
use App\Transformers\BrandTransformer;
use Illuminate\Http\JsonResponse;

class BrandController extends ApiController
{
    /**
     * @var BrandService
     */
    private $brandService;

    /**
     * @var BrandTransformer
     */
    private $brandTransformer;

    public function __construct
    (
        BrandService $brandService,
        BrandTransformer $brandTransformer
    )
    {
        $this->brandService = $brandService;
        $this->brandTransformer = $brandTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|null
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->brandService->getAll();

        return $this->respond($this->brandTransformer->transformCollection($collection));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse
     */
    public function store(Store $request): ?JsonResponse
    {
        if ($new = $this->brandService->store($request->only('name'))) {
            return $this->respond($this->brandTransformer->transform($new));
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
        $id = $request->brand;

        if ($model = $this->brandService->getById((int)$id)) {
            return $this->respond($this->brandTransformer->transform($model));
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
        $id = $request->brand;

        if ($updated = $this->brandService->updateById((int)$id, $request->only('name'))) {
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
        $id = $request->brand;

        if ($deleted = $this->brandService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
