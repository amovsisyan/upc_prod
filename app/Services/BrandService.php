<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 7:55 AM
 */

namespace App\Services;


use App\Models\Brand;

class BrandService extends BasicService
{
    public function __construct
    (
        Brand $brandModel
    )
    {
        $this->model = $brandModel;
    }

    /**
     * @param array $storeData
     * @return Brand|null
     */
    public function store(array $storeData): ?Brand
    {
        return $this->model->create($storeData);
    }

    /**
     * @param int $id
     * @return Brand|null
     */
    public function getById(int $id): ?Brand
    {
        return $this->model->find($id);
    }
}