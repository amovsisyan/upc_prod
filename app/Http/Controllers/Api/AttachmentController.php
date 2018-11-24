<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Attachment\Destroy;
use App\Http\Requests\Api\Attachment\Show;
use App\Http\Requests\Api\Attachment\Store;
use App\Http\Requests\Api\Attachment\Update;
use App\Services\AttachmentService;
use Illuminate\Http\JsonResponse;

class AttachmentController extends ApiController
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct
    (
        AttachmentService $attachmentService
    )
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|null
     */
    public function index(): ?JsonResponse
    {
        $collection = $this->attachmentService->getAll();

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
        if ($newOnes = $this->attachmentService->store($request->only(array('product_id', 'images', 'videos')))) {
            return $this->respond($newOnes->toArray());
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
        $id = $request->attachment;
        $with = !empty($request->only('with')) ? array_values($request->only('with')) : array();

        if ($model = $this->attachmentService->getById((int)$id, $with)) {
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
        $id = $request->attachment;

        if ($updated = $this->attachmentService->updateById((int)$id, $request->only(array('product_id')))) {
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
        $id = $request->attachment;

        if ($deleted = $this->attachmentService->delete((int)$id)) {
            return $this->respondWithSuccess();
        }

        return $this->respondInternalError();
    }
}
