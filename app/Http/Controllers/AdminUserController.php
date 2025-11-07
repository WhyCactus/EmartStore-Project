<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class AdminUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return view('admin.pages.userList', compact('users'));
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading users: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $this->userService->changeStatus($id);
            return redirect()->back()->with('success','Change Status Success');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Server Error' . $e->getMessage());
        }
    }
}
