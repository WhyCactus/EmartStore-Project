<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditRoleRequest;
use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;
use Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->getAllRoles();
        return view('admin.pages.roleList', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleRepository->getAllPermissions();
        return view('admin.pages.newRole', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $role = $this->roleRepository->createRole($validatedData);

            if (!empty($validatedData['permission'])) {
                $this->roleRepository->syncPermissions($role, $validatedData['permission']);
            }
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
        } catch (\Throwable $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the role.');
        }

    }

    public function edit($id)
    {
        $role = $this->roleRepository->getRoleById($id);
        $permissions = $this->roleRepository->getAllPermissions();
        $rolePermissions = $this->roleRepository->getRolePermissions($id);

        return view('admin.pages.editRole', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(EditRoleRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $role = $this->roleRepository->updateRole($id, $validatedData);

            if (!empty($validatedData['permission'])) {
                $this->roleRepository->syncPermissions($role, $validatedData['permission']);
            }
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the role.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleRepository->deleteRole($id);
            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the role.');
        }
    }
}
