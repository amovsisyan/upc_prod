<?php

namespace App\Http\Requests\Api\Attachment;

use App\Http\Requests\Api\ApiRequestCombined;
use App\Models\Attachment;
use Illuminate\Validation\Rule;

class Update extends ApiRequestCombined
{
    /**
     * Add Route parameter to validation
     *
     * @return array
     */
    public function all($keys = null)
    {
        $productId = parent::all('product_id')['product_id'];
        $imgLen = isset(parent::all($keys)['images']) ? count(parent::all($keys)['images']) : 0;
        $vidLen = isset(parent::all($keys)['videos']) ? count(parent::all($keys)['videos']) : 0;

        $routeParamsMergedWithRequest =  array_replace_recursive(
            parent::all($keys),
            $this->route()->parameters(),
            array('already_attached_quantity' => Attachment::where('product_id', $productId)->count() + $imgLen + $vidLen)
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
        $tableName = config('app.database.dbNames.attachments');

        return [
            'already_attached_quantity' => ['required', 'integer', 'max:9'],
            'product_id' => ['required', 'integer', Rule::exists($productTableName, 'id')],
            'attachment' => ['required', Rule::exists($tableName, 'id')]
        ];
    }
}
