<?php

namespace App\Services;

use App\Constants\SortName;
use App\Repositories\HomeRepository;

class HomeService {
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository) {
        $this->homeRepository = $homeRepository;
    }

    public function getProductsByCategory($categoryId, $sort = SortName::SORT_NEWEST, $perPage = 9) {
        return $this->homeRepository->getProductsByCategory($categoryId, $sort, $perPage);
    }

    public function getProductsByBrand($brandId, $sort = SortName::SORT_NEWEST, $perPage = 9) {
        return $this->homeRepository->getProductsByBrand($brandId, $sort, $perPage);
    }

    public function getCategories() {
        return $this->homeRepository->getCategories();
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

    public function getAllProducts($sort = SortName::SORT_NEWEST, $perPage = 9) {
        return $this->homeRepository->getAllProducts($sort, $perPage);
    }
}
