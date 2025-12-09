@extends('admin.layouts.app')

@section('title', 'Edit Category - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Category</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Category List</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        Edit Category
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update-category', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="category_name" class="form-control"
                                    value="{{ old('category_name', $category->category_name) }}" required>
                                @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <div>
                                    @if (isset($category->image) && $category->image)
                                        <img src="{{ minioUrl($category->image) }}" alt="Category Image"
                                            style="max-width: 100px; max-height: 100px;">
                                    @endif
                                </div>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
