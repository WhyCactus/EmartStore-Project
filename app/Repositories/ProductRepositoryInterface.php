<?php

namespace  App\Repositories;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getAllWithRelations(array $relations = []);
    public function getByIdWithRelations($id, array $relations = []);
    public function getRelatedProducts($id);
    public function getProductByIdWithRelations($id, $relations = ['brand', 'category']);
}
