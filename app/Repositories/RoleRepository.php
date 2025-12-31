<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function getAllRoles()
    {
        return Role::get();
    }

    public function getAllPermissions()
    {
        return Permission::get();
    }

    public function createRole(array $data)
    {
        return Role::create(['name' => $data['name']]);
    }

    public function getRoleById($id)
    {
        return Role::findById($id);
    }

    public function updateRole($id, array $data)
    {
        $role = $this->getRoleById($id);
        $role->update(['name' => $data['name']]);
        return $role;
    }

    public function getRolePermissions($id)
    {
        return $this->getRoleById($id)->permissions()->pluck('id')->toArray();
    }

    public function syncPermissions(Role $role, array $permissions): void
    {
        $permissionIds = array_map('intval', $permissions);
        $role->syncPermissions($permissionIds);
    }

    public function deleteRole($id): bool
    {
        return $this->getRoleById($id)->delete();
    }
}
