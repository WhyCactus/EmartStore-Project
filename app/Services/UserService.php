<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function getCurrentUser()
    {
        return $this->userRepository->getCurrentUser();
    }

    public function updateAccount(array $data)
    {
        return $this->userRepository->updateCurrentUser($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function changePassword(array $data)
    {
        return $this->userRepository->changeCurrentUserPassword($data);
    }

    public function changeUserPassword($id, array $data)
    {
        return $this->userRepository->changePassword($id, $data);
    }
}
