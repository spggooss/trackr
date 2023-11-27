<?php

namespace Database\Seeders;

use App\Models\Permission\Permission;
use App\Models\Role\Role;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    public function run()
    {
        $this->setAdmin();
        $this->setWebshopAdmin();
        $this->setEditor();
        $this->setPackageHandler();
    }

    public function setAdmin()
    {
        // Retrieve a role
        $role = Role::where('name', 'super_admin')->first();

        // Retrieve some permissions
        $permissions = Permission::whereIn('name',
            [
                'read packages',
                'view admin users',
                'create admin users',
                'edit admin users',
                'delete admin users',
                'read webshop users',
                'create webshop users',
                'edit webshop users',
                'delete webshop users',
                'edit packages post company',
                'mass import packages',
                'get package labels',
                'edit packages',
                'delete packages',
                'create packages',
                'edit package pickup date',
            ])->get();

        // Attach the permissions to the role
        $role->permissions()->attach($permissions);
    }

    public function setWebshopAdmin()
    {
        // Retrieve a role
        $role = Role::where('name', 'webshop_admin')->first();

        // Retrieve some permissions
        $permissions = Permission::whereIn('name',
            [
                'read webshop users',
                'create webshop users',
                'edit webshop users',
                'delete webshop users',
                'edit packages post company',
                'mass import packages',
                'get package labels',
                'read packages',
                'edit packages',
                'delete packages',
                'create packages',
                'edit package pickup date',
            ])->get();

        // Attach the permissions to the role
        $role->permissions()->attach($permissions);
    }

    public function setEditor()
    {
        // Retrieve a role
        $role = Role::where('name', 'editor')->first();

        // Retrieve some permissions
        $permissions = Permission::whereIn('name',
            [
                'edit packages post company',
                'mass import packages',
                'get package labels',
                'read packages',
                'edit packages',
                'delete packages',
                'create packages',
                'edit package pickup date'
            ])->get();

        // Attach the permissions to the role
        $role->permissions()->attach($permissions);
    }

    public function setPackageHandler()
    {
        // Retrieve a role
        $role = Role::where('name', 'package_handler')->first();

        // Retrieve some permissions
        $permissions = Permission::whereIn('name',
            [
                'read packages',
                'get package labels',
            ])->get();

        // Attach the permissions to the role
        $role->permissions()->attach($permissions);
    }
}
