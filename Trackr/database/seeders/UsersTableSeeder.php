<?php

namespace Database\Seeders;

use App\Models\User\User;
use App\Models\User\UserRole;
use App\Models\Webshop\Webshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Maak een super admin
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@trackr.nl',
            'password' => Hash::make('superadmin123'),
        ])->assignRole(UserRole::create(UserRole::SUPER_ADMIN));

        Webshop::create([
            'name' => 'bol.com',
        ]);
        // Maak een webshop admin
        User::create([
            'name' => 'Bol',
            'email' => 'admin@bol.com',
            'webshop_id' => 1, // 'bol.com
            'password' => Hash::make('bolcom'),
        ])->assignRole(UserRole::create(UserRole::WEB_SHOP_ADMIN));

        // Maak een user
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
        ])->assignRole(UserRole::create(UserRole::USER));
    }
}
