<?php

namespace App\Http\Requests\Api\ProductVersion;

use App\Http\Requests\Api\ApiRequestCombined;
use Illuminate\Validation\Rule;

class Store extends ApiRequestCombined
{
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
        $productVersionsTableName = config('app.database.dbNames.product_versions');
        $productsTableName = config('app.database.dbNames.products');
        $brandsTableName = config('app.database.dbNames.brands');

        $columns = [
            'title' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.title'),
            'active' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.active'),
        ];

        return [
            'product_id' => ['required', 'integer', Rule::exists($productsTableName, 'id')],
            'brand_id' => ['required', 'integer', Rule::exists($brandsTableName, 'id')],
            'title' => ['required', 'string', 'max:' . $columns['title']],
            'description' => ['required', 'string', 'max:2000'],
            'width' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'length' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
            'active' => ['required', 'integer', Rule::in($columns['active'])],
        ];
    }
}
