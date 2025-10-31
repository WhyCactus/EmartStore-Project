@extends('admin.layouts.app')

@section('title', 'Brand List - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Brands</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Brands</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Brands
                    </div>
                    <a href="{{ route('admin.brand.create-brand') }}" class="btn btn-primary text-end">
                        <i class="bi bi-plus-circle"></i>
                        Create Brand
                    </a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->brand_name }}</td>
                                    <td>{{ $brand->status }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.brand.edit-brand', $brand->id) }}"
                                                class="btn btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.brand.toggle-status', $brand->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($brand->status == 'active')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-dash-circle"></i>
                                                    </button>
                                                @elseif ($brand->status == 'inactive')
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
