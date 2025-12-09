@extends('admin.layouts.app')

@section('title', 'Category List - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Categories</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Categories
                    </div>
                    <a href="{{ route('admin.category.create-category') }}" class="btn btn-primary text-end">
                        <i class="bi bi-plus-circle"></i>
                        Create Category
                    </a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td>
                                        <img src="{{ minioUrl($category->image) }}" alt="Category Name"
                                            style="width: 100px; height: 100px;" />
                                    </td>
                                    <td>{{ $category->status }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.category.edit-category', $category->id) }}"
                                                class="btn btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.category.toggle-status', $category->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($category->status == 'active')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-dash-circle"></i>
                                                    </button>
                                                @elseif ($category->status == 'inactive')
                                                    <button type="submit" class="btn btn-outline-success">
                                                        <i class="bi bi-plus-circle"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
