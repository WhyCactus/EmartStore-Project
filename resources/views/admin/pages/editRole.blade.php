@extends('admin.layouts.app')

@section('title', 'Edit Role - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Role</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Role List</a></li>
                <li class="breadcrumb-item active">Edit Role</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        Edit Role
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.roles.update-role', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" required
                                    value="{{ $role->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Permissions</label>
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox" name="permission[{{ $permission->id }}]"
                                                value="{{ $permission->id }}" class="form-check-input"
                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('permission')
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
