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
     * @param string $path
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getByPath(string $path): ?\Illuminate\Database\Eloquent\Collection
    {
        return $this->model->attachments()->where('path', $path)->get();
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
     * @param string $upc
     * @param bool $cloneDeep
     * @return Product|null
     */
    public function cloneById(int $id, string $upc, bool $cloneDeep): ?Product
    {
        $with = array('attachments', 'categories', 'subCategories');
        $product = $this->getById($id, $with);
        if ($upc) {
            if ($product->getUPC() === (int)$upc) {
                // already existed, not cloned
                return $product;
            }
        }

        $newProduct = $this->model->create(array('upc' => $upc));
        $newProductId = $newProduct->getId();
        $oldActiveVersion = $product->activeProductVersions()->first();

        if ($oldActiveVersion) {
            // create new clone for product version
            $oldAttachments = $product->attachments()->get();
            $newProduct->productVersions()->create($oldActiveVersion->toArray());

            if ($cloneDeep) {
                // create new clone for product attachments
                $attachmentInsertData = $oldAttachments->map(function($item) use($newProductId) {
                    $imageName = explode('/', $item['path'])[1];
                    $newPath = $newProductId . '/' . $imageName;
                    // clone also attached files
                    Storage::disk('productAttachments')->copy($item['path'], $newPath);

                    return array('path' => $newPath, 'thumbnail' => $item['thumbnail']);
                })->toArray();
            } else {
                // create new clone for product attachments
                $attachmentInsertData = $oldAttachments->map(function($item)  {
                    return array('path' => $item['path'], 'thumbnail' => $item['thumbnail']);
                })->toArray();
            }

            // create new attachments
            $newProduct->attachments()->createMany($attachmentInsertData);
        }

        return $this->getById($newProductId, $with);
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


    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $product = $this->getById($id, array('attachments'));
        $attachments = $product->attachments;

        foreach ($attachments as $attachment) {
            if ($this->getByPath($attachment['path'])->count() <= 1) {
                Storage::disk('productAttachments')->delete($attachment['path']);
            }
        }

        if (!count(Storage::disk('productAttachments')->allFiles($id))) {
            Storage::disk('productAttachments')->deleteDirectory($id);
        }

        return (bool)$product->delete();
    }
}