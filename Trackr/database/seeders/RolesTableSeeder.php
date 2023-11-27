<?php

namespace Database\Seeders;

use App\Models\Role\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'super_admin',
        ]);

        Role::create([
            'name' => 'webshop_admin',
        ]);

        Role::create([
            'name' => 'editor',
        ]);

        Role::create([
            'name' => 'package_handler',
        ]);

        Role::create([
            'name' => 'user',
        ]);
    }
}
