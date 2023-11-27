<?php

namespace App\Models\Role;

interface RolesRepository
{
    /**
     * @return Role[]
     */
    public function all();

    /**
     * @return Role
     */
    public function getAdminRole();

    /**
     * @param Role $role
     * @return Role
     */
    public function store(Role $role);

    /**
     * @param int $id
     * @return Role|null
     */
    public function findById(int $id): ?Role;

    /**
     * @param int $page
     * @param int $limit
     * @return Role[]
     */
    public function getPaged(
        int $page,
        int $limit,
    );
}
