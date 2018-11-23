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
     * @return ProductVersion|null
     */
    public function getById(int $id): ?ProductVersion
    {
        return $this->model->find($id);
    }
}