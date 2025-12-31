@extends('admin.layouts.app')

@section('title', 'Edit User - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">User List</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        Edit User
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update-user', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="username" class="form-control" placeholder="Name"
                                    value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone"
                                    value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Role</label>
                                <select name="role[]" class="form-control" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ isset($userRole[$role]) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
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
