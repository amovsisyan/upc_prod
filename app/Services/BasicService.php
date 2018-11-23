<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/23/18
 * Time: 11:15 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class BasicService
{
    /**
     * @var
     */
    protected $model;

    /**
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->model->all();
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