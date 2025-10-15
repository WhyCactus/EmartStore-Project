@extends('admin.layouts.app')

@section('title', 'Edit Brand - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">New Brand</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Brand List</a></li>
                <li class="breadcrumb-item active">Edit Brand</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        Edit Brand
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update-brand', $brands->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="brand_name" class="form-control"
                                    value="{{ old('brand_name', $brands->brand_name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active" {{ $brands->status == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ $brands->status == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
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
