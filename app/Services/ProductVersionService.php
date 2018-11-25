<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 11:58 PM
 */

namespace App\Services;


use App\Models\ProductVersion;

class ProductVersionService extends BasicService
{
    public function __construct
    (
        ProductVersion $productVersionModel
    )
    {
        $this->model = $productVersionModel;
    }

    /**
     * @param array $storeData
     * @return ProductVersion|null
     */
    public function store(array $storeData): ?ProductVersion
    {
        return $this->model->create($storeData);
    }

    /**
     * @param int $id
     * @param array $with
     * @return ProductVersion|null
     */
    public function getById(int $id, array $with = array()): ?ProductVersion
    {
        return $this->model->where('id', $id)->with($with)->first();
    }

    /**
     * @param int $id
     * @param array $updateData
     * @return ProductVersion|null
     */
    public function makeVersionById(int $id, array $updateData): ?ProductVersion
    {
        if ($alreadyExists = $this->model->where($updateData)->first()) {
            // if such version already exists, return that one
            return $alreadyExists;
        }

        // such version does not exists
        if ((int)$updateData['active'] === 1) {
            // if we want active version, need to check all old actives for that prod id and set it 0
            $this->deactivateAllByProdVersion((int)$updateData['product_id']);
        }

        // in the last, save new version
        return $this->store($updateData);
    }

    /**
     * @param int $productId
     * @return mixed
     */
    private function deactivateAllByProdVersion(int $productId)
    {
        return $this->model->where('product_id', $productId)->update(['active' => 0]);
    }
}