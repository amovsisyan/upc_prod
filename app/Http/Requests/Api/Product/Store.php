<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequestCombined;
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
        $tableName = config('app.database.dbNames.products');
        $categoryTableName = config('app.database.dbNames.categories');
        $brandsTableName = config('app.database.dbNames.brands');
        $productVersionsTableName = config('app.database.dbNames.product_versions');

        $maxFileSize = UploadedFile::getMaxFilesize();
        $maxImageFileSize = $maxFileSize > (20 * 1024) ? (20 * 1024) : $maxFileSize;
        $maxVideoFileSize = $maxFileSize > (50 * 1024) ? (50 * 1024) : $maxFileSize;
        $columns = [
            'title' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.title'),
            'description' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.description'),
            'active' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.active'),
        ];

        return [
            'attaching_quantity' => ['required', 'integer', 'max:9'],
            'upc' => ['required', 'integer', 'max:999999999', Rule::unique($tableName, 'upc')],

            // category, subcategory part
            'categories' => ['required', 'array'],
            'subCategories' => ['array'],
            'categories.*' => ['integer', Rule::exists($categoryTableName, 'id')->whereNull('parent_id')],
            'subCategories.*' => ['integer', Rule::exists($categoryTableName, 'id')->whereNotNull('parent_id')],

            // attachment part
            "images" => ['required_without:videos', 'array'],
            "videos" => ['required_without:images', 'array'],
            "images.*" => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:' . $maxImageFileSize, 'dimensions:min_width=100,min_height=100'],
            "videos.*" => ['mimetypes:video/mp4,video/3gpp,video/x-msvideo,video/x-ms-wmv', 'max:' . $maxVideoFileSize],

            // product version part
            'brand_id' => ['required', 'integer', Rule::exists($brandsTableName, 'id')],
            'title' => ['required', 'string', 'max:' . $columns['title']],
            'description' => ['required', 'string', 'max:' . $columns['description']],
            'width' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'length' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
        ];
    }
}
