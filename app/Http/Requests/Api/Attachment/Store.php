<?php

namespace App\Http\Requests\Api\Attachment;

use App\Http\Requests\Api\ApiRequestCombined;
use App\Models\Attachment;
use Illuminate\Validation\Rule;

class Store extends ApiRequestCombined
{
    /**
     * Add Route parameter to validation
     *
     * @return array
     */
    public function all($keys = null)
    {
        $productId = parent::all('product_id')['product_id'];

        $routeParamsMergedWithRequest =  array_replace_recursive(
            parent::all($keys),
            $this->route()->parameters(),
            array('already_attached_quantity' => Attachment::where('product_id', $productId)->count())
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
        $productTableName = config('app.database.dbNames.products');

        return [
            'already_attached_quantity' => ['required', 'integer', 'max:9'],
            'product_id' => ['required', 'integer', Rule::exists($productTableName, 'id')],
            "images" => ['required_without:videos', 'array'],
            "videos" => ['required_without:images', 'array'],
            "images.*" => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:20000'],
            "videos.*" => ['mimetypes:video/mp4,video/3gpp,video/x-msvideo,video/x-ms-wmv', 'max:50000'],
        ];
    }
}
