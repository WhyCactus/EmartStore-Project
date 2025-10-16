<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepositoryInterface;

class CategoryRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->getById($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->getById($id);
        return $category->delete();
    }

    public function getAllWithRelations(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function getByIdWithRelations($id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }
}
