<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository implements AuthRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->model->create($data);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function resetPassword(User $user, $password)
    {
        $user
            ->forceFill([
                'password' => Hash::make($password),
            ])
            ->setRememberToken(Str::random(60));

        $user->save();
    }
}
