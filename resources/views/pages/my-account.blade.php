@extends('layouts.app')

@section('title', 'My Account - E Shop')

@section('content')
    <!-- My Account Start -->
    <div class="my-account">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="dashboard-nav" data-toggle="pill" href="#dashboard-tab"
                            role="tab">Dashboard</a>
                        <a class="nav-link" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab">Orders</a>
                        <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab">Account
                            Details</a>
                        <a class="nav-link" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="dashboard-tab" role="tabpanel"
                            aria-labelledby="dashboard-nav">
                            <h4>Dashboard</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In condimentum quam ac mi viverra
                                dictum. In efficitur ipsum diam, at dignissim lorem tempor in. Vivamus tempor hendrerit
                                finibus. Nulla tristique viverra nisl, sit amet bibendum ante suscipit non. Praesent in
                                faucibus tellus, sed gravida lacus. Vivamus eu diam eros. Aliquam et sapien eget arcu
                                rhoncus scelerisque.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Order Code</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td>${{ $order->total_amount }}</td>
                                                <td>{{ $order->order_status }}</td>
                                                <td>
                                                    <a href="{{ route('my-account.order', $order->id) }}" class="btn btn-success">
                                                        <i class="bi bi-dash-circle"></i>
                                                        <span>View</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <h4>Account Details</h4>
                            <form action="{{ route('my-account.update-account') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username"
                                            value="{{ Auth::user()->username }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone number</label>
                                        <input type="tel" class="form-control" name="phone"
                                            value="{{ Auth::user()->phone }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ Auth::user()->email }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit">Update Account</button>
                                        <br><br>
                                    </div>
                                </div>
                            </form>
                            <h4>Password change</h4>
                            <form action="{{ route('my-account.change-password') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="password" placeholder="Current Password" name="currentPassword">
                                        @error('currentPassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" placeholder="New Password" name="newPassword">
                                        @error('newPassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" placeholder="Confirm Password" name="confirmPassword">
                                        @error('confirmPassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Account End -->
@endsection
