<?php

namespace App\Http\Controllers;

use App\Constants\CommonStatus;
use App\Events\LoginFailed;
use App\Events\UserLoggedIn;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\AuthRepositoryInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Log;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->status !== CommonStatus::ACTIVE) {
                $user = Auth::user();
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                event(new LoginFailed($user->email, $request->ip(), $request->userAgent(), 'inactive_account'));
                return redirect()->back()->with('error', 'Your account is inactive. Please contact the administrator.');
            }
            event(new UserLoggedIn(Auth::user(), $request->ip(), $request->userAgent(), 'web'));
            return redirect()->route('home');
        }
        event(new LoginFailed($request->email, $request->ip(), $request->userAgent(), 'invalid_credentials'));
        return back()->with('error', 'Email or password is incorrect.')->onlyInput('email');
    }

    public function register(RegisterRequest $request)
    {
        $this->authRepository->create($request->validated());

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->query('email');

        if (!$token || !$email) {
            return redirect()
                ->back()
                ->withErrors(['email' => 'The password reset token is invalid.']);
        }

        return view('auth.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset($request->validated(), function ($user, $password) {
            $user
                ->forceFill([
                    'password' => Hash::make($password),
                ])
                ->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
