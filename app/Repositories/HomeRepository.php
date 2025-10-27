<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeRepository
{
    public function getFeaturedProducts()
    {
        return Product::with('brand', 'category')
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }

    public function getRecentProducts()
    {
        return Product::with('brand', 'category')
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCategories()
    {
        return Category::withCount('products')
            ->limit(6)
            ->get();
    }

    public function getSortQuery($sort)
    {
        return function ($query) use ($sort) {
            if ($sort === 'newest') {
                return $query->orderBy('created_at', 'desc');
            } elseif ($sort === 'popular') {
                return $query->orderBy('sold_count', 'desc');
            }
            return $query->orderBy('created_at', 'desc');
        };
    }

    public function getBaseProductsQuery($sort)
    {
        return Product::with('brand', 'category')
            ->when($sort, $this->getSortQuery($sort))
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0);
    }

    public function getAllProducts($sort = 'newest', $perPage = 9)
    {
        return $this->getBaseProductsQuery($sort)->paginate($perPage);
    }

    public function getProductsByCategory($categoryId, $sort = 'newest', $perPage = 9)
    {
        return $this->getBaseProductsQuery($sort)
            ->where('category_id', $categoryId)
            ->paginate($perPage);
    }

    public function getProductsByBrand($brandId, $sort = 'newest', $perPage = 9)
    {
        return $this->getBaseProductsQuery($sort)
            ->where('brand_id', $brandId)
            ->paginate($perPage);
    }

    public function getFilterData()
    {
        return [
            'categories' => Category::withCount('products')->get(),
            'brands' => Brand::withCount('products')->get(),
        ];
    }
}
