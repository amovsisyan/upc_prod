<?php

namespace App\Http\Requests\Api\Brands;

use App\Http\Requests\Api\ApiRequestCombined;

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
        $tableName = config('app.database.dbNames.brands');

        return [
            'name' => ['required', 'string', 'max:' . config('app.database.dbColumnLengths.' . $tableName . '.name')] // todo if needed unique
        ];
    }
}
