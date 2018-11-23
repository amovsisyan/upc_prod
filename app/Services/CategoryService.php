<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 9:43 PM
 */

namespace App\Services;


use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * @var Category
     */
    private $model;

    public function __construct
    (
        Category $categoryModel
    )
    {
        $this->model = $categoryModel;
    }

    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $storeData
     * @return Category|null
     */
    public function store(array $storeData): ?Category
    {
        return $this->model->create($storeData);
    }

    /**
     * @param int $id
     * @return Category|null
     */
    public function getById(int $id): ?Category
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @param array $updateData
     * @return bool
     */
    public function updateById(int $id, array $updateData): bool
    {
        return (bool)$this->model->where('id', $id)
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