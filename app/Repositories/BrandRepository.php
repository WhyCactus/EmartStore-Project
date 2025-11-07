<?php

namespace App\Repositories;

use App\Constants\CommonStatus;
use App\Models\Brand;
use App\Repositories\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $brand = $this->getById($id);
        $brand->update($data);
        return $brand;
    }

    public function delete($id)
    {
        $brand = $this->getById($id);
        return $brand->delete();
    }

    public function toggleBrandStatus($id)
    {
        $brand = $this->getById($id);

        if ($brand->status === CommonStatus::ACTIVE) {
            $brand->status = CommonStatus::INACTIVE;
        } else {
            $brand->status = CommonStatus::ACTIVE;
        }

        $brand->save();
        return $brand;
    }
}
