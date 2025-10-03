@extends('layouts.app')

@section('title', 'Login - E Shop')

@section('content')
<!-- Login Start -->
<div class="login">
    <div class="container">
        <div class="section-header">
            <h3>User Registration & Login</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec viverra at massa sit amet ultricies. Nullam consequat, mauris non interdum cursus
            </p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="login-form">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label>E-mail / Username</label>
                                <input class="form-control" type="text" name="email" placeholder="E-mail or Username" required>
                            </div>
                            <div class="col-md-12">
                                <label>Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Keep me signed in</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn" type="submit">Login</button>
                            </div>
                            <div class="col-md-12 mt-3">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="register-form">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
                            </div>
                            <div class="col-md-6">
                                <label>E-mail</label>
                                <input class="form-control" type="email" name="email" placeholder="E-mail" required>
                            </div>
                            <div class="col-md-6">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" name="phone" placeholder="Mobile No">
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-md-6">
                                <label>Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
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
