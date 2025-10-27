@extends('admin.layouts.app')

@section('title')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">New Brand</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Brand List</a></li>
                <li class="breadcrumb-item active">New Brand</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        New Brand
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.store-brand') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="brand_name" class="form-control" placeholder="Name" required>
                                @error('brand_name')
                                    <span class="text-danger">{{ $message}}</span>
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
