<?php

namespace App\Http\Requests\Api\Attachment;

use App\Http\Requests\Api\ApiRequestCombined;
use App\Models\Attachment;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $maxFileSize = UploadedFile::getMaxFilesize();
        $maxImageFileSize = $maxFileSize > (20 * 1024) ? (20 * 1024) : $maxFileSize;
        $maxVideoFileSize = $maxFileSize > (50 * 1024) ? (50 * 1024) : $maxFileSize;

        return [
            'already_attached_quantity' => ['required', 'integer', 'max:9'],
            'product_id' => ['required', 'integer', Rule::exists($productTableName, 'id')],
            "images" => ['required_without:videos', 'array'],
            "videos" => ['required_without:images', 'array'],
            "images.*" => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:' . $maxImageFileSize, 'dimensions:min_width=100,min_height=100'],
            "videos.*" => ['mimetypes:video/mp4,video/3gpp,video/x-msvideo,video/x-ms-wmv', 'max:' . $maxVideoFileSize],
        ];
    }
}
