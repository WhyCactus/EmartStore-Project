<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('pages.my-account');
    }

    public function updateAccount(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userService->updateAccount($data);

            return back()->with('success', 'Update account successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error updating account: ' . $e->getMessage());
        }
    }

    public function changePassword(PasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userService->changePassword($data);

            return back()->with('success', 'Change password successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error changing password: ' . $e->getMessage());
        }
    }
}
