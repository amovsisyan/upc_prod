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
     * @param array $with
     * @return Brand|null
     */
    public function getById(int $id, array $with = array()): ?Brand
    {
        return $this->model->where('id', $id)->with($with)->first();
    }
}