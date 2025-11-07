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
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Users
                </div>
                <div class="card-body">
                    <div class="">
                        
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
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
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
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
