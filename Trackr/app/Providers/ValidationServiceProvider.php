<?php

namespace App\Providers;

use App\Validation\PickupTimeValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot(){
        Validator::extend('pickup_time', PickupTimeValidator::class);
    }

}
