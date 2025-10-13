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
}
