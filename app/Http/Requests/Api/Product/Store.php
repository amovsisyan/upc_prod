<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequestCombined;

class Store extends ApiRequestCombined
{
    /**
     * Add Route parameter to validation
     *
     * @return array
     */
    public function all($keys = null)
    {
        $imgLen = isset(parent::all($keys)['images']) ? count(parent::all($keys)['images']) : 0;
        $vidLen = isset(parent::all($keys)['videos']) ? count(parent::all($keys)['videos']) : 0;

        $routeParamsMergedWithRequest =  array_replace_recursive(
            parent::all($keys),
            $this->route()->parameters(),
            array('attaching_quantity' => $imgLen + $vidLen)
        );

        return $routeParamsMergedWithRequest;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // todo auth if needed validate here
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(
            ['attaching_quantity' => ['required', 'integer', 'max:9']],
            StoreRules::getStandardRulesWithAttachments()
        );
    }
}
