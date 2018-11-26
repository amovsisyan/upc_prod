<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/26/18
 * Time: 9:51 PM
 */

namespace App\Http\Requests\Api\Product;

use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StoreRules
{
    /**
     * @return array
     */
    public static function getStandardRules()
    {
        $tableName = config('app.database.dbNames.products');
        $categoryTableName = config('app.database.dbNames.categories');
        $brandsTableName = config('app.database.dbNames.brands');
        $productVersionsTableName = config('app.database.dbNames.product_versions');

        $columns = [
            'title' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.title'),
            'description' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.description'),
            'active' => config('app.database.dbColumnLengths.' . $productVersionsTableName . '.active'),
        ];

        return array(
            'upc' => ['required', 'integer', 'max:999999999', Rule::unique($tableName, 'upc')],

            // category, subcategory part
            'categories' => ['required', 'array'],
            'subCategories' => ['array'],
            'categories.*' => ['integer', Rule::exists($categoryTableName, 'id')->whereNull('parent_id')],
            'subCategories.*' => ['integer', Rule::exists($categoryTableName, 'id')->whereNotNull('parent_id')],

            // product version part
            'brand_id' => ['required', 'integer', Rule::exists($brandsTableName, 'id')],
            'title' => ['required', 'string', 'max:' . $columns['title']],
            'description' => ['required', 'string', 'max:' . $columns['description']],
            'width' => ['required', 'integer'],
            'height' => ['required', 'integer'],
            'length' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
        );
    }

    /**
     * @return array
     */
    public static function getStandardRulesWithAttachments()
    {
        $maxFileSize = UploadedFile::getMaxFilesize();
        $maxImageFileSize = $maxFileSize > (20 * 1024) ? (20 * 1024) : $maxFileSize;
        $maxVideoFileSize = $maxFileSize > (50 * 1024) ? (50 * 1024) : $maxFileSize;
        return array_merge(array(
            // attachment part
            "images" => ['required_without:videos', 'array'],
            "videos" => ['required_without:images', 'array'],
            "images.*" => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:' . $maxImageFileSize, 'dimensions:min_width=100,min_height=100'],
            "videos.*" => ['mimetypes:video/mp4,video/3gpp,video/x-msvideo,video/x-ms-wmv', 'max:' . $maxVideoFileSize]),
            self::getStandardRules()
        );
    }
}