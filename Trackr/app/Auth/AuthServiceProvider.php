<?php

namespace App\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        require app_path('Auth/policies.php');

    }

}
