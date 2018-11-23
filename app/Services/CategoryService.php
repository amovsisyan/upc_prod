<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 9:43 PM
 */

namespace App\Services;


use App\Models\Category;

class CategoryService extends BasicService
{
    public function __construct
    (
        Category $categoryModel
    )
    {
        $this->model = $categoryModel;
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
}