<?php

namespace App\Repositories;

interface ProductVariantRepositoryInterface
{
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function attributes($variantId, array $attributes);
    public function getById($id);
}