<?php

namespace App\Services;

use App\Models\Attribute;
use App\Repositories\ProductRepository;
use App\Repositories\ProductVariantRepository;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepository;
    protected $productVariantRepository;

    public function __construct(ProductRepository $productRepository, ProductVariantRepository $productVariantRepository)
    {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
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
        DB::beginTransaction();
        try {
            $productType = $data['product_type'] ?? 'single';

            if ($productType === 'single') {
                $originalPrice = $data['original_price'];
                $quantityInStock = $data['quantity_in_stock'];
            } else {
                $originalPrice = $data['variants'][0]['price'] ?? 0;
                $quantityInStock = array_sum(array_column($data['variants'], 'quantity_in_stock'));
            }


            $productData = [
                'product_name' => $data['product_name'],
                'sku' => $data['sku'],
                'original_price' => $originalPrice,
                'discounted_price' => $data['discounted_price'] ?? null,
                'quantity_in_stock' => $quantityInStock,
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'brand_id' => $data['brand_id'],
                'status' => 'active',
                'sold_count' => 0,
            ];

            if (isset($data['image']) && $data['image']->isValid()) {
                $imagePath = $data['image']->store('products', 'public');
                $productData['image'] = $imagePath;
                $storageFiles[] = $imagePath;
            }

            $product = $this->productRepository->create($productData);

            if (isset($data['variants']) && is_array($data['variants'])) {
                foreach ($data['variants'] as $variant) {
                    $variantData = [
                        'product_id' => $product->id,
                        'sku' => $variant['sku'],
                        'price' => $variant['price'],
                        'quantity_in_stock' => $variant['quantity_in_stock'],
                    ];

                    if (isset($variant['image']) && $variant['image']->isValid()) {
                        $variantImagePath = $variant['image']->store('product_variants', 'public');
                        $variantData['image'] = $variantImagePath;
                        $storageFiles[] = $variantImagePath;
                    }

                    $createdVariant = $this->productVariantRepository->create($variantData);

                    if (isset($variant['attributes']) && is_array($variant['attributes'])) {
                        foreach ($variant['attributes'] as $attribute) {
                            $attributeId = $attribute['attribute_id'] ?? null;

                            $attributeName = $attribute['attribute_name'] ?? $attribute['name'] ?? null;
                            $attributeValue = $attribute['attribute_value'] ?? $attribute['value'] ?? null;

                            if (!$attributeId && !empty($attributeName)) {
                                $attr = Attribute::firstOrCreate(
                                    ['name' => $attributeName],
                                );
                                $attributeId = $attr->id;
                            }

                            if (!$attributeId || empty($attributeValue)) {
                                continue;
                            }

                            $createdVariant->attributes()->create([
                                'attribute_id' => $attributeId,
                                'value' => $attributeValue,
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            return $product;
        } catch (\Throwable $e) {
            DB::rollBack();
            if (!empty($storageFiles)) {
                foreach ($storageFiles as $filePath) {
                    try {
                        Storage::disk('public')->delete($filePath);
                    } catch (\Throwable $th) {
                        throw new \Exception("Failed to delete storage file: " . $th->getMessage());
                    }
                }
            }
            throw new \Exception("Failed to create product: " . $e->getMessage());
        }
    }

    public function updateProduct($id, array $data)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->getByIdWithRelations($id, ['productVariants', 'productVariants.attributes']);
            $storageFiles = [];

            $productType = $data['product_type'] ?? 'single';

            if ($productType === 'single') {
                $originalPrice = $data['original_price'];
                $quantityInStock = $data['quantity_in_stock'];
            } else {
                $originalPrice = $data['variants'][0]['price'] ?? 0;
                $quantityInStock = array_sum(array_column($data['variants'], 'quantity_in_stock'));
            }

            $updateData = [
                'product_name' => $data['product_name'],
                'sku' => $data['sku'],
                'original_price' => $originalPrice,
                'discounted_price' => $data['discounted_price'] ?? null,
                'quantity_in_stock' => $quantityInStock,
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'brand_id' => $data['brand_id'],
            ];

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($data['image']->isValid()) {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }

                    $imagePath = $data['image']->store('products', 'public');
                    $updateData['image'] = $imagePath;
                    $storageFiles[] = $imagePath;
                }
            }

            $this->productRepository->update($id, $updateData);
            $product->refresh();

            if (isset($data['variants']) && is_array($data['variants'])) {
                $existingVariantIds = $product->productVariants->pluck('id')->toArray();
                $updatedVariantIds = [];

                foreach ($data['variants'] as $variant) {
                    $variantData = [
                        'product_id' => $product->id,
                        'sku' => $variant['sku'],
                        'price' => $variant['price'],
                        'quantity_in_stock' => $variant['quantity_in_stock'],
                    ];

                    if (isset($variant['image']) && $variant['image'] instanceof UploadedFile) {
                        if ($variant['image']->isValid()) {
                            if (isset($variant['id'])) {
                                $existingVariant = $this->productVariantRepository->getById($variant['id']);
                                if ($existingVariant && $existingVariant->image) {
                                    Storage::disk('public')->delete($existingVariant->image);
                                }
                            }

                            $variantImagePath = $variant['image']->store('product_variants', 'public');
                            $variantData['image'] = $variantImagePath;
                            $storageFiles[] = $variantImagePath;
                        }
                    }

                    if (isset($variant['id']) && in_array($variant['id'], $existingVariantIds)) {
                        $this->productVariantRepository->update($variantData, $variant['id']);
                        $updatedVariant = $this->productVariantRepository->getById($variant['id']);
                        $updatedVariantIds[] = $variant['id'];
                    } else {
                        $updatedVariant = $this->productVariantRepository->create($variantData);
                        $updatedVariantIds[] = $updatedVariant->id;
                    }

                    if (isset($variant['attributes']) && is_array($variant['attributes'])) {
                        $updatedVariant->attributes()->delete();

                        foreach ($variant['attributes'] as $attribute) {
                            $attributeId = $attribute['attribute_id'] ?? null;
                            $attributeName = $attribute['attribute_name'] ?? $attribute['name'] ?? null;
                            $attributeValue = $attribute['attribute_value'] ?? $attribute['value'] ?? null;

                            if (!$attributeId && !empty($attributeName)) {
                                $attr = Attribute::firstOrCreate(
                                    ['name' => $attributeName],
                                );
                                $attributeId = $attr->id;
                            }

                            if (!$attributeId || empty($attributeValue)) {
                                continue;
                            }

                            $updatedVariant->attributes()->create([
                                'attribute_id' => $attributeId,
                                'value' => $attributeValue,
                            ]);
                        }
                    }
                }
                $variantsToDelete = array_diff($existingVariantIds, $updatedVariantIds);
                foreach ($variantsToDelete as $variantId) {
                    $variantToDelete = $this->productVariantRepository->getById($variantId);
                    if ($variantToDelete && $variantToDelete->image) {
                        Storage::disk('public')->delete($variantToDelete->image);
                    }
                    $this->productVariantRepository->delete($variantId);
                }

                $product->refresh();

                $totalQuantity = $product->productVariants()->sum('quantity_in_stock');
                $this->productRepository->update($id, ['quantity_in_stock' => $totalQuantity]);
            }
            DB::commit();
            return $product;
        } catch (\Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            if (!empty($storageFiles)) {
                foreach ($storageFiles as $filePath) {
                    try {
                        Storage::disk('public')->delete($filePath);
                    } catch (\Throwable $th) {
                        throw new \Exception("Failed to delete storage file: ");
                    }
                }
            }
            throw new \Exception("Failed to update product: ");
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = $this->productRepository->getById($id);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            if ($product->productVariants) {
                foreach ($product->productVariants as $variant) {
                    if ($variant->image) {
                        Storage::disk('public')->delete($variant->image);
                    }
                    $this->productVariantRepository->delete($variant->id);
                }
            }

            if ($product->attributes) {
                $product->attributes()->delete();
            }
            return $this->productRepository->delete($id);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error deleting product: ');
        }
    }

    public function getRelatedProducts($id)
    {
        try {
            return $this->productRepository->getRelatedProducts($id);
        } catch (\Throwable $e) {
            throw new \Exception("Failed to get related products: " . $e->getMessage());
        }
    }
}
