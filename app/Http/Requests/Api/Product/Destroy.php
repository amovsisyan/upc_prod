<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequestCombined;
use Illuminate\Validation\Rule;

class Destroy extends ApiRequestCombined
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

        return [
            'product' => ['required', Rule::exists($tableName, 'id')]
        ];
    }
}
