<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequestCombined;

class StoreBulk extends ApiRequestCombined
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
        return [
            'file' => ['required', 'mimetypes:text/plain']
        ];
    }
}
