@extends('admin.layouts.app')

@section('title', 'Create User - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">New User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">User List</a></li>
                <li class="breadcrumb-item active">New User</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        New User
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.store-user') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="username" class="form-control" placeholder="Name" required>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Role</label>
                                <select name="role[]" class="form-control" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
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
    </main>
@endsection
