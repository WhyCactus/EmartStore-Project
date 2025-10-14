@extends('admin.layouts.app')

@section('title', 'New category - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">New Category</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Category List</a></li>
                <li class="breadcrumb-item active">New Category</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        New Category
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.store-category') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="category_name" class="form-control" placeholder="Name" required>

                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" placeholder="Image">
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
