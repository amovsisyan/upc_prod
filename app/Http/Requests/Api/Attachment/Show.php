<?php

namespace App\Http\Requests\Api\Attachment;

use App\Http\Requests\Api\ApiRequestCombined;
use Illuminate\Validation\Rule;

class Show extends ApiRequestCombined
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
        $tableName = config('app.database.dbNames.attachments');

        return [
            'attachment' => ['required', Rule::exists($tableName, 'id')],
            'with' => [Rule::in(array('product'))]
        ];
    }
}
