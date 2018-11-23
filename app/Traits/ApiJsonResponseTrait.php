<?php

namespace App\Traits;

use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait ApiJsonResponseTrait
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var int
     */
    protected $statusCode = SymfonyResponse::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * The request has succeeded
     *
     * @param $message
     *
     * @return mixed
     */
    public function respondSuccess($message = 'Success')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_OK)->respondWithSuccess($message);
    }

    /**
     * Return the built up json response
     *
     * @param       $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Wrap the response in an error object
     *
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        if ($this->getStatusCode() === SymfonyResponse::HTTP_OK) {
            $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respond([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * Wrap the response in an error object
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithErrors($message = [])
    {
        if ($this->getStatusCode() === SymfonyResponse::HTTP_OK) {
            $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respond([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * Wrap the response in a data object
     *
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithSuccess($message = 'Success')
    {
        return $this->respond([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }
}