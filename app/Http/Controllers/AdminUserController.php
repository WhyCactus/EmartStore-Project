<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Imports\UsersImport;
use App\Services\UserService;
use Illuminate\Http\Request;
use Log;
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

    public function create()
    {
        try {
            $roles = $this->userService->getAllRoles();
            return view('admin.pages.newUser', compact('roles'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $this->userService->createUser($request->all());
            return redirect()->route('admin.users')->with('success', 'Add user successfully!');
        } catch (\Throwable $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Error creating user: ');
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            $roles = $this->userService->getAllRoles();
            $userRole = $user->roles->pluck('name', 'name')->all();

            return view('admin.pages.editUser', compact('user', 'roles', 'userRole'));
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Error loading user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->userService->updateAdminUser($id, $request->all());
            $this->userService->assignRoleToUser($id, $request->input('role', []));
            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        } catch (\Throwable $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Error updating user: ');
        }
    }
}
