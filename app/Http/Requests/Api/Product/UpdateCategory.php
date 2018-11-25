<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequestCombined;
use Illuminate\Validation\Rule;

class UpdateCategory extends ApiRequestCombined
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
        $tableName = config('app.database.dbNames.products');
        $categoryTableName = config('app.database.dbNames.categories');

        return [
            'product' => ['required', Rule::exists($tableName, 'id')],
            // category, subcategory part
            'categories' => ['required', 'array'],
            'subCategories' => ['array'],
            'categories.*' => ['integer', Rule::exists($categoryTableName, 'id')->whereNull('parent_id')],
            'subCategories.*' => ['integer', Rule::exists($categoryTableName, 'id')->whereNotNull('parent_id')],
        ];
    }
}
