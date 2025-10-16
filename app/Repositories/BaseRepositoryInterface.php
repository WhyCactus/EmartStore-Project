<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function getAll();
    public function getAllWithRelations(array $relations = []);
    public function getById($id);
    public function getByIdWithRelations($id, array $relations = []);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
