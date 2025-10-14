<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.pages.categoryList', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.pages.newCategory', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $data = array_merge($request->all(), ['status' => 'active']);

        Category::create($data);

        return redirect()->route('admin.categories')->with('success', 'Add category successfully!');
    }
}
