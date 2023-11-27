<?php

namespace App\Models\Role;

class EloquentRolesRepository implements RolesRepository
{
    /**
     * @return Role[]
     */
    public function all(): array
    {
        return Role::all()->all();
    }

    /**
     * @param Role $role
     * @return void
     */
    public function store(Role $role)
    {
        $this->store($role);
    }

    /**
     * @param int $id
     * @return Role|null
     */
    public function findById(int $id): ?Role
    {
        return Role::where('id', $id)->first();
    }

    /**
     * @param int $page
     * @param int $limit
     * @return void
     */
    public function getPaged(int $page, int $limit)
    {
        return Role::all()->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * @return Role
     */
    public function getAdminRole(): Role
    {
        return Role::where('name', 'super_admin')->first();
    }
}
