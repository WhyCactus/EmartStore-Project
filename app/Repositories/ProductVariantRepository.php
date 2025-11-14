<?php

namespace App\Repositories;

use App\Models\ProductVariant;
use App\Models\VariantAttributes;

class ProductVariantRepository implements ProductVariantRepositoryInterface
{
    protected $model;

    public function __construct(ProductVariant $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $variant = $this->model->findOrFail($id);
        $variant->update($data);
        return $variant->fresh();
    }

    public function delete($id)
    {
        $variant = $this->model->findOrFail($id);
        return $variant->delete();
    }

    public function attributes($variantId, array $attributes)
    {
        foreach ($attributes as $attribute) {
            VariantAttributes::updateOrCreate(
                [
                    'product_variant_id' => $variantId,
                    'attribute_id' => $attribute['attribute_id'],
                ],
                [
                    'value' => $attribute['value'],
                ]
            );
        }
    }

    public function getById($id)
    {
        return $this->model->with('attributes')->findOrFail($id);
    }
}