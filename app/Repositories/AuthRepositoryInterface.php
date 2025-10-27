<?php

namespace App\Repositories;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function create(array $data);
    public function findByEmail($email);
    public function resetPassword(User $user, $password);
}
