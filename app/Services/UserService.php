<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Managers\UserManager;
use App\Models\User;

class UserService
{
    protected UserManager $manager;

    public function __construct(UserManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all users with role relation.
     */
    public function getAllUsers()
    {
        $repository = $this->manager->getRepository();
        return $repository->getAllWithRelations(['role']);
    }

    /**
     * Get user by ID with relations.
     */
    public function getUserById(int $id, array $relations = ['role']): ?User
    {
        $repository = $this->manager->getRepository();
        return $repository->findByIdWithRelations($id, $relations);
    }

    /**
     * Create a new user from request.
     */
    public function createUser(StoreUserRequest $request): User
    {
        $userData = [
            User::NAME_COLUMN => $request->name,
            User::USERNAME_COLUMN => $request->username,
            User::EMAIL_COLUMN => $request->email,
            User::PASSWORD_COLUMN => $request->password,
            User::ROLE_ID_COLUMN => $request->role_id,
        ];

        return $this->manager->createUser($userData);
    }

    /**
     * Update a user from request.
     */
    public function updateUser(User $user, UpdateUserRequest $request): User
    {
        $userData = [
            User::NAME_COLUMN => $request->name,
            User::USERNAME_COLUMN => $request->username,
            User::EMAIL_COLUMN => $request->email,
            User::ROLE_ID_COLUMN => $request->role_id,
        ];

        // Only include password if provided
        if ($request->filled('password')) {
            $userData[User::PASSWORD_COLUMN] = $request->password;
        }

        return $this->manager->updateUser($user, $userData);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user): bool
    {
        return $this->manager->deleteUser($user);
    }

    /**
     * Check if email exists for another user.
     */
    public function emailExistsForAnotherUser(string $email, int $excludeUserId): bool
    {
        $repository = $this->manager->getRepository();
        return $repository->emailExistsForAnotherUser($email, $excludeUserId);
    }

    /**
     * Check if username exists for another user.
     */
    public function usernameExistsForAnotherUser(string $username, int $excludeUserId): bool
    {
        $repository = $this->manager->getRepository();
        return $repository->usernameExistsForAnotherUser($username, $excludeUserId);
    }
}

