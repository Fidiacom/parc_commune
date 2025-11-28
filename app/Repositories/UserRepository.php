<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get all users.
     */
    public function getAll()
    {
        return User::latest()->get();
    }

    /**
     * Get all users with relations.
     */
    public function getAllWithRelations(array $relations = [])
    {
        return User::with($relations)->latest()->get();
    }

    /**
     * Find user by ID.
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Find user by ID with relations.
     */
    public function findByIdWithRelations(int $id, array $relations = []): ?User
    {
        return User::with($relations)->find($id);
    }

    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where(User::EMAIL_COLUMN, $email)->first();
    }

    /**
     * Find user by username.
     */
    public function findByUsername(string $username): ?User
    {
        return User::where(User::USERNAME_COLUMN, $username)->first();
    }

    /**
     * Check if email exists for another user.
     */
    public function emailExistsForAnotherUser(string $email, int $excludeUserId): bool
    {
        return User::where(User::EMAIL_COLUMN, $email)
            ->where(User::ID_COLUMN, '!=', $excludeUserId)
            ->exists();
    }

    /**
     * Check if username exists for another user.
     */
    public function usernameExistsForAnotherUser(string $username, int $excludeUserId): bool
    {
        return User::where(User::USERNAME_COLUMN, $username)
            ->where(User::ID_COLUMN, '!=', $excludeUserId)
            ->exists();
    }

    /**
     * Create a new user.
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update a user.
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }
}

