<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;

class AdminCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return view('admin.pages.categoryList', compact('categories'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading categories: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return view('admin.pages.newCategory', compact('categories'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading form: ' . $e->getMessage());
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image');
            }

            $this->categoryService->createCategory($data);
            return redirect()->route('admin.category.categories')->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return view('admin.pages.editCategory', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('admin.category.categories')->with('error', 'Category not found!');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $data['image'] = $request->file('image');
            }

            $this->categoryService->updateCategory($id, $data);
            return redirect()->route('admin.category.categories')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function toggleStatus($id)
    {
        try {
            $this->categoryService->toggleStatus($id);
            return redirect()->back()->with('success', 'Change Status Success');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Server Error');
        }
    }
}
