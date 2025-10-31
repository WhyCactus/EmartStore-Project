<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Http\Requests\BrandRequest;

class AdminBrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        try {
            $brands = $this->brandService->getAllBrands();
            return view('admin.pages.brandList', compact('brands'));
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading brands: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $brands = $this->brandService->getAllBrands();
            return view('admin.pages.newBrand', compact('brands'));
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading form: ' . $e->getMessage());
        }

    }

    public function store(BrandRequest $request)
    {
        try {
            $data = $request->validated();
            $this->brandService->createBrand($data);
            return redirect()->route('admin.brands')->with('success', 'Add brand successfully!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error creating brand: ' . $e->getMessage())
                ->withInput();
        }

    }

    public function edit($id)
    {
        try {
            $brand = $this->brandService->getBrandById($id);
            return view('admin.pages.editBrand', compact('brand'));
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading form: ' . $e->getMessage());
        }
    }

    public function update(BrandRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->brandService->updateBrand($id, $data);
            return redirect()->route('admin.brands')->with('success', 'Update brand successfully!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error updating brand: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function toggleStatus($id)
    {
        try {
            $this->brandService->toggleStatus($id);
            return redirect()->back()->with('success', 'Change Status Success');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Server Error');
        }
    }
}
