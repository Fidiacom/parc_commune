<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Check if current user is admin.
     */
    private function isAdmin(): bool
    {
        $user = Auth::user();
        if (!$user || !$user->getRoleId()) {
            return false;
        }

        $role = Role::find($user->getRoleId());
        return $role && $role->getLabel() === 'Administrateur';
    }

    /**
     * Display a listing of users.
     */
    public function index()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can access this page.');
        }

        $users = $this->userService->getAllUsers();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can access this page.');
        }

        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can access this page.');
        }

        $this->userService->createUser($request);

        Alert::success('Success', 'User created successfully');
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can access this page.');
        }

        $roles = Role::all();

        try {
            $user = $this->userService->getUserById($id);
            
            if (!$user) {
                Alert::error('Error', 'User not found');
                return redirect()->route('admin.users.index');
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid user ID');
            return redirect()->route('admin.users.index');
        }

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can access this page.');
        }

        try {
            $user = $this->userService->getUserById($id);
            
            if (!$user) {
                Alert::error('Error', 'User not found');
                return redirect()->route('admin.users.index');
            }

            $this->userService->updateUser($user, $request);

            Alert::success('Success', 'User updated successfully');
            return redirect()->route('admin.users.index');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to update user: ' . $th->getMessage());
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can access this page.');
        }

        try {
            $user = $this->userService->getUserById($id);
            
            if (!$user) {
                Alert::error('Error', 'User not found');
                return redirect()->route('admin.users.index');
            }

            // Prevent deleting yourself
            if ($user->getId() === Auth::id()) {
                Alert::error('Error', 'You cannot delete your own account');
                return redirect()->route('admin.users.index');
            }

            $this->userService->deleteUser($user);

            Alert::success('Success', 'User deleted successfully');
            return redirect()->route('admin.users.index');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to delete user: ' . $th->getMessage());
            return redirect()->route('admin.users.index');
        }
    }
}

