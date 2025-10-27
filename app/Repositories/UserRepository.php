<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

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
}
