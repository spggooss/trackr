<?php

namespace App\Auth\Policies;
use App\Models\Role\RolesRepository;
use App\Models\User\User;

class AdminPolicy
{
    public function viewAdminUsers(User $user)
    {
        $permissions = $user->role->permissions;
        foreach ($permissions as $permission) {
            if ($permission->name === 'view admin users') {
                return true;
            }
        }
        return false;
    }

    public function editAdminUsers(User $user)
    {
        $permissions = $user->role->permissions;
        foreach ($permissions as $permission) {
            if ($permission->name === 'edit admin users') {
                return true;
            }
        }
        return false;
    }

    public function deleteAdminUsers(User $user)
    {
        $permissions = $user->role->permissions;
        foreach ($permissions as $permission) {
            if ($permission->name === 'delete admin users') {
                return true;
            }
        }
        return false;
    }

    public function createAdminUsers(User $user)
    {
        $permissions = $user->role->permissions;
        foreach ($permissions as $permission) {
            if ($permission->name === 'create admin users') {
                return true;
            }
        }
        return false;
    }

}
