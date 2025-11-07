@extends('client.layouts.app')

@section('title', 'Login - E Shop')

@section('content')
    <!-- Login Start -->
    <div class="login">
        <div class="container">
            <div class="section-header">
                <h3>User Registration & Login</h3>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="login-form">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" name="email"
                                        placeholder="E-mail or Username" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Password"
                                        required>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Login</button>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="register-form">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Username</label>
                                    <input class="form-control" type="text" name="username" placeholder="Username"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="email" name="email" placeholder="E-mail" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Phone number</label>
                                    <input class="form-control" type="" name="phone" placeholder="Phone number">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Password"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn" type="submit">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->
@endsection
