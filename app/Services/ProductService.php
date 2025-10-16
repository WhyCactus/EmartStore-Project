<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProductsWithRelations($relations = ['brand', 'category'])
    {
        return $this->productRepository->getAllWithRelations($relations);
    }

    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function getProductByIdWithRelations($id, $relations = ['brand', 'category'])
    {
        return $this->productRepository->getByIdWithRelations($id, $relations);
    }

    public function createProduct(array $data)
    {
        $productData = [
            'product_name' => $data['product_name'],
            'product_code' => $data['product_code'],
            'original_price' => $data['original_price'],
            'discounted_price' => $data['discounted_price'] ?? null,
            'quantity_in_stock' => $data['quantity_in_stock'],
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
            'status' => 'active',
            'sold_count' => 0,
        ];

        if (isset($data['image']) && $data['image']->isValid()) {
            $imagePath = $data['image']->store('products', 'public');
            $productData['image'] = $imagePath;
        }

        return $this->productRepository->create($productData);
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->productRepository->getById($id);

        $updateData = [
            'product_name' => $data['product_name'],
            'product_code' => $data['product_code'],
            'original_price' => $data['original_price'],
            'discounted_price' => $data['discounted_price'] ?? null,
            'quantity_in_stock' => $data['quantity_in_stock'],
            'description' => $data['description'] ?? null,
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
        ];

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($data['image']->isValid()) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $imagePath = $data['image']->store('products', 'public');
                $updateData['image'] = $imagePath;
            }
        }

        return $this->productRepository->update($id, $updateData);
    }

    public function deleteProduct($id)
    {
        $product = $this->productRepository->getById($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $this->productRepository->delete($id);
    }
}
