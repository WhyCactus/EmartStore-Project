@extends('client.layouts.app')

@section('title', 'Forgot Password - E Shop')

@section('content')
    <!-- Forgot Password Start -->
    <div class="login">
        <div class="container">
            <div class="section-header">
                <h3>Forgot Password</h3>
            </div>
            <div class="col-md-6 offset-md-3">
                <div class="forgot-password-form">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div>
                            <div class="col-md-12">
                                <label class="form-label">E-mail</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    name="email" placeholder="Please enter your email" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button class="btn" type="submit">Reset Password</button>
                            </div>

                            <div class="col-md-12">
                                <a href="{{ route('login') }}">Back to Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
