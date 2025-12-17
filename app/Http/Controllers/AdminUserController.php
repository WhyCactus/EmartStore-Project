<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Services\UserService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            return redirect()->back()->with('success', 'Change Status Success');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Server Error' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|extensions:csv,xlsx,xls|max:5120',
            ]);

            Excel::import(new UsersImport(), $request->file('file'));

            return back()->with('success', 'Users imported successfully!');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }
}
