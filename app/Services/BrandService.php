<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 7:55 AM
 */

namespace App\Services;


use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    /**
     * @var Brand
     */
    private $brandModel;

    public function __construct
    (
        Brand $brandModel
    )
    {
        $this->brandModel = $brandModel;
    }

    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->brandModel->all();
    }

    /**
     * @param array $storeData
     * @return Brand|null
     */
    public function store(array $storeData): ?Brand
    {
        return $this->brandModel->create($storeData);
    }

    /**
     * @param int $id
     * @return Brand|null
     */
    public function getById(int $id): ?Brand
    {
        return $this->brandModel->find($id);
    }

    /**
     * @param int $id
     * @param array $updateData
     * @return bool
     */
    public function updateById(int $id, array $updateData): bool
    {
        return (bool)$this->brandModel->where('id', $id)
            ->update($updateData);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        return (bool)$this->getById($id)->delete();
    }
}