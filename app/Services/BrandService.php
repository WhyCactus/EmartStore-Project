<?php

namespace App\Services;

use App\Repositories\BrandRepository;

class BrandService
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands()
    {
        return $this->brandRepository->getAll();
    }

    public function getBrandById($id)
    {
        return $this->brandRepository->getById($id);
    }

    public function createBrand(array $data)
    {
        $brandData = [
            'brand_name' => $data['brand_name'],
            'status' => 'active',
        ];

        return $this->brandRepository->create($brandData);
    }

    public function updateBrand($id, array $data)
    {
        $this->brandRepository->getById($id);

        $updatedData = [
            'brand_name' => $data['brand_name'],
        ];

        return $this->brandRepository->update($id, $updatedData);
    }

    public function toggleStatus($id)
    {
        $brand = $this->brandRepository->toggleBrandStatus($id);
        return $brand;
    }
}
