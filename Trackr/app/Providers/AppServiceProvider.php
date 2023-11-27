<?php

namespace App\Providers;

use App\Http\Composers\LanguageComposer;
use App\Models\Address\AddressRepository;
use App\Models\Address\EloquentAddressRepository;
use App\Models\Package\EloquentPackagesRepository;
use App\Models\Package\EloquentPostCompanyRepository;
use App\Models\Package\PackagesRepository;
use App\Models\Package\PostCompanyRepository;
use App\Models\Package\EloquentReviewRepository;
use App\Models\Package\ReviewRepository;
use App\Models\Role\EloquentRolesRepository;
use App\Models\Role\RolesRepository;
use App\Models\User\EloquentUsersRepository;
use App\Models\User\UsersRepository;
use App\Models\Webshop\EloquentWebshopsRepository;
use App\Models\Webshop\WebshopsRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
           UsersRepository::class,
           EloquentUsersRepository::class
        );
        $this->app->bind(
            WebshopsRepository::class,
            EloquentWebshopsRepository::class
        );
        $this->app->bind(
            RolesRepository::class,
            EloquentRolesRepository::class
        );
        $this->app->bind(
            PackagesRepository::class,
            EloquentPackagesRepository::class
        );
        $this->app->bind(
            AddressRepository::class,
            EloquentAddressRepository::class
        );
        $this->app->bind(
            PostCompanyRepository::class,
            EloquentPostCompanyRepository::class
          );
      $this->app->bind(
            ReviewRepository::class,
            EloquentReviewRepository::class
        );
    }
}
