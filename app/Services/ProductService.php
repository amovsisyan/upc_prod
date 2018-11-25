<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 10:42 PM
 */

namespace App\Services;


use App\Helpers\FileHelper;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductService extends BasicService
{
    public function __construct
    (
        Product $productModel
    )
    {
        $this->model = $productModel;
    }

    /**
     * @param array $storeData
     * @return Product|null
     */
    public function store(array $storeData): ?Product
    {
        // STEP 1 create product
        $stored = $this->model->create(array('upc' => $storeData['upc']));

        // STEP 2 attach category/subcategory
        $stored->categories()->attach($storeData['categories']);
        $stored->subCategories()->attach($storeData['subCategories']);

        // STEP 3 store related attachments
        $videos = $storeData['videos'] ?? array();
        $images = $storeData['images'] ?? array();
        $files = array_merge($videos, $images);
        $this->storeAttachments($stored, $files);

        // STEP 4 Attach new product version
        $prodVersionStoredData = array(
            'brand_id' => $storeData['brand_id'],
            'title' => $storeData['title'],
            'description' => $storeData['description'],
            'width' => $storeData['width'],
            'height' => $storeData['height'],
            'length' => $storeData['length'],
            'weight' => $storeData['weight'],
            'active' => 1
        );
        $stored->productVersions()->create($prodVersionStoredData);

        return $this->getById($stored->getId(), array('categories', 'subCategories', 'productVersions', 'attachments'));
    }

    /**
     * @param int $id
     * @param array $with
     * @return Product|null
     */
    public function getById(int $id, array $with = array()): ?Product
    {
        return $this->model->where('id', $id)->with($with)->first();
    }

    /**
     * @param int $id
     * @param array $updateData
     * @return Product|null
     */
    public function updateCategoriesById(int $id, array $updateData): ?Product
    {
        $model = $this->getById($id);
        $model->categories()->detach();
        $model->subCategories()->detach();

        $model->categories()->attach($updateData['categories']);
        $model->subCategories()->attach($updateData['subCategories']);

        return $this->getById($id, array('categories', 'subCategories'));
    }

    /**
     * @param Product $product
     * @param $files
     * @return Collection
     */
    private function storeAttachments(Product $product, $files): Collection
    {
        $attachments = array();
        $disk = 'productAttachments';
        $prodId = $product->getId();

        foreach ($files as $file) {
            $fileName = FileHelper::makeFileName($file->getClientOriginalExtension(), $disk);
            $storeDatum  =array(
                'product_id' => $prodId,
                'path' => $prodId . '/' . $fileName,
                'thumbnail' => FileHelper::getDimensions($file),
            );

            $attachments[] = $product->attachments()->create($storeDatum);

            Storage::disk($disk)->put(
                '/' . $prodId . '/' . $fileName,
                File::get($file),
                'public'
            ); // todo put in mutators after
        }

        return collect($attachments);
    }
}