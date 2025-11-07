<?php

namespace App\Repositories;

use App\Constants\CommonStatus;
use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
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

    public function toggleCategoryStatus($id)
    {
        $category = $this->getById($id);

        if ($category->status === CommonStatus::ACTIVE) {
            $category->status = CommonStatus::INACTIVE;
        } else {
            $category->status = CommonStatus::ACTIVE;
        }

        $category->save();
        return $category;
    }
}
