@extends('layouts.app')

@section('title', 'Reset Password - E Shop')

@section('content')
    <div class="login">
        <div class="container">
            <div class="section-header">
                <h3>Reset Password</h3>
            </div>
            <div class="col-md-6 offset-md-3">
                <div>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="col-md-12">
                            <input type="email" class="form-control" id="email"
                                name="email" value="{{ $email ?? old('email') }}" required autofocus hidden>
                        </div>

                        <div class="col-md-12">
                            <label for="password" class="form-label">New Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" placeholder="Enter new password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password" placeholder="Confirm new password">
                        </div>

                        <div class="col-md-12">
                            <button class="btn" type="submit">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
