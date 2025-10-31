<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function createCategory(array $data)
    {
        $categoryData = [
            'category_name' => $data['category_name'],
            'status' => 'active',
        ];

        if (isset($data['image']) && $data['image']->isValid()) {
            $imagePath = $data['image']->store('categories', 'public');
            $categoryData['image'] = $imagePath;
        }

        return $this->categoryRepository->create($categoryData);
    }

    public function updateCategory($id, $data)
    {
        $category = $this->categoryRepository->getById($id);

        $updatedData = [
            'category_name' => $data['category_name'],
        ];

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($data['image']->isValid()) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $imagePath = $data['image']->store('categories', 'public');
                $updatedData['image'] = $imagePath;
            }
        }

        return $this->categoryRepository->update($id, $updatedData);
    }

    public function deleteCategory($id)
    {
        $category = $this->categoryRepository->getById($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return $this->categoryRepository->delete($id);
    }

    public function toggleStatus($id)
    {
        $status = $this->categoryRepository->toggleCategoryStatus($id);
        return $status;
    }
}
