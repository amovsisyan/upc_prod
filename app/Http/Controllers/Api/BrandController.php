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
        $brandCollection = $this->brandService->getAll();

        return $this->respond($this->brandTransformer->transformCollection($brandCollection));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse
     */
    public function store(Store $request): ?JsonResponse
    {
        $structuredStoreData = array(
            'name' => $request->name
        );

        if ($newBrand = $this->brandService->store($structuredStoreData)) {
            return $this->respond($this->brandTransformer->transform($newBrand));
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

        if ($brand = $this->brandService->getById((int)$id)) {
            return $this->respond($this->brandTransformer->transform($brand));
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
        $structuredUpdateData = array(
            'name' => $request->name
        );

        if ($updatedBrand = $this->brandService->updateById((int)$id, $structuredUpdateData)) {
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

        if ($updatedBrand = $this->brandService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
