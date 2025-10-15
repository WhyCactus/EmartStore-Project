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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'category_name.required' => 'Category name is required',
            'category_name.string' => 'Category name must be a string',
            'category_name.max' => 'Category name must not exceed 255 characters',
            'image.image' => 'Image must be an image file',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF file',
            'image.max' => 'Image size must not exceed 2MB',
        ]);

        $data = [
            'category_name' => $request->category_name,
            'status' => 'active',
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        Category::create($data);

        return redirect()->route('admin.categories')->with('success', 'Add category successfully!');
    }

    public function edit($id)
    {
        $category = Category::all()->find($id);

        return view('admin.pages.editCategory', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ],[
            'category_name.required' => 'Category name is required',
            'category_name.string' => 'Category name must be a string',
            'category_name.max' => 'Category name must not exceed 255 characters',
            'image.image' => 'Image must be an image file',
            'image.max' => 'Image size must not exceed 2MB',
        ]);

        $category = Category::findOrFail($id);

        $data = [
            'category_name' => $request->category_name,
            'status' => 'active',
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        $category->update($data);

        return redirect()->route('admin.categories')->with('success', 'Update category successfully!');
    }
}
