<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 10:42 PM
 */

namespace App\Services;


use App\Models\Product;

class ProductService
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
        return $this->model->create($storeData);
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function getById(int $id): ?Product
    {
        return $this->model->find($id);
    }
}