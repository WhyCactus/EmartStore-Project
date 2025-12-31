@extends('admin.layouts.app')

@section('title', 'User List - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <div>
                <form action="{{ route('admin.user-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 align-items-center mt-2 mb-2">
                        <div class="col-auto">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Import Users</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Users
                    </div>
                    <a href="{{ route('admin.create-user') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i>
                        New User
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.edit-user', $user->id) }}"
                                                class="btn btn-outline-primary">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.toggle-status', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($user->status == 'active')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-dash-circle"></i>
                                                    </button>
                                                @elseif ($user->status == 'inactive')
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
