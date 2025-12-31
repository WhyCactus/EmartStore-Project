<?php

namespace App\Repositories;

use App\Constants\CommonStatus;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // COMMON
    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    // CLIENT
    public function getCurrentUser()
    {
        return auth()->user();
    }

    public function update($id, array $data)
    {
        $user = $this->getById($id);
        $user->update($data);
        return $user;
    }

    public function updateCurrentUser(array $data)
    {
        $user = $this->getCurrentUser();
        $user->update($data);
        return $user;
    }

    public function changePassword($id, array $data)
    {
        $user = $this->getById($id);

        if (!Hash::check($data['currentPassword'], $user->password)) {
            throw new \Exception('Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($data['newPassword']),
        ]);

        return $user;
    }

    public function changeCurrentUserPassword(array $data)
    {
        $user = $this->getCurrentUser();

        if (!Hash::check($data['currentPassword'], $user->password)) {
            throw new \Exception('Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($data['newPassword']),
        ]);

        return $user;
    }

    // ADMIN
    public function toggleUserStatus($id)
    {
        $user = $this->getById($id);

        if ($user->status === CommonStatus::ACTIVE) {
            $user->status = CommonStatus::INACTIVE;
        } else {
            $user->status = CommonStatus::ACTIVE;
        }

        $user->save();
        return $user;
    }

    public function getTotalUsersCount(): int
    {
        return $this->model->where('status', CommonStatus::ACTIVE)->count();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->getById($id);
        $user->update($data);
        return $user;
    }

    public function getRoles()
    {
        return Role::pluck('name', 'name')->all();
    }

    public function assignRole($id, array $data)
    {
        $user = $this->getById($id);
        $user->syncRoles($data);
        return $user;
    }
}
