<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
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
}
