<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllWithRelations(array $relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getByIdWithRelations($id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->getById($id);
        $product->update($data);
        return $product->fresh();
    }

    public function delete($id)
    {
        $product = $this->getById($id);
        return $product->delete();
    }

    public function getRelatedProducts($id)
    {
        return $this->model
            ->with(['brand', 'category'])
            ->where('category_id', $this->getById($id)->category_id)
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->limit(6)
            ->get();
    }

    public function getProductByIdWithRelations($id, $relations = ['brand', 'category'])
    {
        return $this->model->with($relations)->findOrFail($id);
    }
}
