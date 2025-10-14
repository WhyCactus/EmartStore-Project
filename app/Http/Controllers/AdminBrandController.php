<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class AdminBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();

        return view('admin.pages.brandList', compact('brands'));
    }

    public function create()
    {
        $brands = Brand::all();

        return view('admin.pages.newBrand', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required',
        ]);

        $data = array_merge($request->all(), ['status' => 'active']);

        Brand::create($data);

        return redirect()->route('admin.brands')->with('success', 'Add brand successfully!');
    }

    public function toggleStatus(Brand $brand)
    {
        $brand->status = !$brand->status;
        $brand->save();

        return redirect()->route('admin.brands')->with('success', 'Update brand successfully!');
    }
}
