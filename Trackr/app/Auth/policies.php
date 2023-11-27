<?php

use App\Auth\Gates;
use App\Auth\Policies\AdminPolicy;
use App\Auth\Policies\WebshopPolicy;
use Illuminate\Support\Facades\Gate;

Gate::define(Gates::VIEW_ADMIN_USERS, AdminPolicy::class . '@viewAdminUsers');
Gate::define(Gates::CREATE_ADMIN_USERS, AdminPolicy::class . '@createAdminUsers');
Gate::define(Gates::EDIT_ADMIN_USERS, AdminPolicy::class . '@editAdminUsers');
Gate::define(Gates::DELETE_ADMIN_USERS, AdminPolicy::class . '@deleteAdminUsers');
Gate::define(Gates::READ_WEBSHOP_USERS, WebshopPolicy::class . '@readWebshopUsers');
Gate::define(Gates::CREATE_WEBSHOP_USERS, WebshopPolicy::class . '@createWebshopUsers');
Gate::define(Gates::EDIT_WEBSHOP_USERS, WebshopPolicy::class . '@editWebshopUsers');
Gate::define(Gates::DELETE_WEBSHOP_USERS, WebshopPolicy::class . '@deleteWebshopUsers');
Gate::define(Gates::EDIT_PACKAGES_POST_COMPANY, WebshopPolicy::class . '@editPackagesPostCompany');
Gate::define(Gates::MASS_IMPORT_PACKAGES, WebshopPolicy::class . '@massImportPackages');
Gate::define(Gates::GET_PACKAGE_LABELS, WebshopPolicy::class . '@getPackageLabels');
Gate::define(Gates::READ_PACKAGES, WebshopPolicy::class . '@readPackages');
Gate::define(Gates::EDIT_PACKAGES, WebshopPolicy::class . '@editPackages');
Gate::define(Gates::DELETE_PACKAGES, WebshopPolicy::class . '@deletePackages');
Gate::define(Gates::CREATE_PACKAGES, WebshopPolicy::class . '@createPackages');
Gate::define(Gates::EDIT_PACKAGE_PICKUP_DATE, WebshopPolicy::class . '@editPackagePickupDate');
