<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 8:11 PM
 */

namespace App\Http\Requests\Api;

use App\Traits\ApiJsonResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ApiRequestCombined extends FormRequest
{
    use ApiJsonResponseTrait;

    public function expectsJson()
    {
        return true;
    }

    /**
     * Add Route parameter to validation
     *
     * @return array
     */
    public function all($keys = null)
    {
        $routeParamsMergedWithRequest =  array_replace_recursive(
            parent::all($keys),
            $this->route()->parameters()
        );

        return $routeParamsMergedWithRequest;
    }

    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $this->setStatusCode(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->respondWithError($validator->errors());

        throw (new ValidationException($validator, $response))->status(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}