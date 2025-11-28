<?php

namespace App\Managers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserManager
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the repository instance.
     */
    public function getRepository(): UserRepository
    {
        return $this->repository;
    }

    /**
     * Create a user.
     */
    public function createUser(array $userData): User
    {
        // Hash password if provided
        if (isset($userData[User::PASSWORD_COLUMN])) {
            $userData[User::PASSWORD_COLUMN] = Hash::make($userData[User::PASSWORD_COLUMN]);
        }

        return $this->repository->create($userData);
    }

    /**
     * Update a user.
     */
    public function updateUser(User $user, array $userData): User
    {
        // Hash password if provided
        if (isset($userData[User::PASSWORD_COLUMN]) && !empty($userData[User::PASSWORD_COLUMN])) {
            $userData[User::PASSWORD_COLUMN] = Hash::make($userData[User::PASSWORD_COLUMN]);
        } else {
            // Remove password from update if not provided
            unset($userData[User::PASSWORD_COLUMN]);
        }

        $this->repository->update($user, $userData);

        return $user->fresh();
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user): bool
    {
        return $this->repository->delete($user);
    }
}

