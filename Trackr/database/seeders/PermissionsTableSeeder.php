<?php

namespace Database\Seeders;

use App\Models\Permission\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            [
                'name' => 'read packages',
            ],
            [
                'name' => 'view admin users',
            ],
            [
                'name' => 'create admin users',
            ],
            [
                'name' => 'edit admin users',
            ],
            [
                'name' => 'delete admin users',
            ],
            [
                'name' => 'read webshop users',
            ],
            [
                'name' => 'create webshop users',
            ],
            [
                'name' => 'edit webshop users',
            ],
            [
                'name' => 'delete webshop users',
            ],
            [
                'name' => 'edit packages post company'
            ],
            [
                'name' => 'mass import packages'
            ],
            [
                'name' => 'get package labels'
            ],
            [
                'name' => 'edit packages'
            ],
            [
                'name' => 'create packages'
            ],
            [
                'name' => 'delete packages'
            ],
            [
                'name' => 'edit package pickup date'
            ]
        ];

        // Insert Permissions
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
