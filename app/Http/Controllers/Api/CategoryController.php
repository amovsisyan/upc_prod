<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Category\Destroy;
use App\Http\Requests\Api\Category\Show;
use App\Http\Requests\Api\Category\Store;
use App\Http\Requests\Api\Category\Update;
use App\Services\CategoryService;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;

class CategoryController extends ApiController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var CategoryTransformer
     */
    private $categoryTransformer;

    public function __construct
    (
        CategoryService $categoryService,
        CategoryTransformer $categoryTransformer
    )
    {
        $this->categoryService = $categoryService;
        $this->categoryTransformer = $categoryTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|null
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->categoryService->getAll();

        return $this->respond($this->categoryTransformer->transformCollection($collection));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return JsonResponse|null
     */
    public function store(Store $request): ?JsonResponse
    {
        if ($new = $this->categoryService->store($request->only(['name', 'parent_id']))) {
            return $this->respond($this->categoryTransformer->transform($new));
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
        $id = $request->category;

        if ($model = $this->categoryService->getById((int)$id)) {
            return $this->respond($this->categoryTransformer->transform($model));
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
        $id = $request->category;

        if ($updated = $this->categoryService->updateById((int)$id, $request->only(['name', 'parent_id']))) {
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
        $id = $request->category;

        if ($deleted = $this->categoryService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
