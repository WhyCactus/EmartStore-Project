<?php

namespace App\Services;

use App\Repositories\HomeRepository;

class HomeService {
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository) {
        $this->homeRepository = $homeRepository;
    }

    public function getProductsByCategory($categoryId, $sort = 'newest', $perPage = 9) {
        return $this->homeRepository->getProductsByCategory($categoryId, $sort, $perPage);
    }

    public function getProductsByBrand($brandId, $sort = 'newest', $perPage = 9) {
        return $this->homeRepository->getProductsByBrand($brandId, $sort, $perPage);
    }

    public function getProducts($sort = 'newest', $perPage = 9) {
        return $this->homeRepository->getProducts($sort, $perPage);
    }

    public function getCategories() {
        return $this->homeRepository->getCategories();
    }

    public function getBrands() {
        return $this->homeRepository->getBrands();
    }

    public function getFilterData() {
        return $this->homeRepository->getFilterData();
    }

    public function getFeaturedProducts() {
        return $this->homeRepository->getFeaturedProducts();
    }

    public function getRecentProducts() {
        return $this->homeRepository->getRecentProducts();
    }

    public function getAllProducts($sort = 'newest', $perPage = 9) {
        return $this->homeRepository->getAllProducts($sort, $perPage);
    }
}
