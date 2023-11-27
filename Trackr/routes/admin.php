<?php

use App\Auth\Gates;
use App\Http\Controllers\Web\Admin\CalendarController;
use App\Http\Controllers\Web\Admin\WebshopUsersController;
use App\Http\Controllers\Web\Packages\PackagesController;
use App\Http\Controllers\Web\SuperAdmin\UsersController;
use App\Http\Controllers\Web\SuperAdmin\WebshopsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'super-admin', 'middleware' => 'can:' . Gates::VIEW_ADMIN_USERS], function () {
    Route::get('/users', [UsersController::class, 'index'])->name('super-admin.users.index');
});

Route::group(['prefix' => 'super-admin', 'middleware' => 'can:' . Gates::VIEW_ADMIN_USERS], function () {
    Route::get('/webshops', [WebshopsController::class, 'index'])->name('super-admin.webshops.index');
});

Route::group(['prefix' => 'super-admin', 'middleware' => 'can:' . Gates::CREATE_ADMIN_USERS], function () {
    Route::get('/users/create', [UsersController::class, 'create'])->name('super-admin.users.create');
    Route::post('/users/create', [UsersController::class, 'store'])->name('super-admin.users.store');
});
Route::group(['prefix' => 'super-admin', 'middleware' => 'can:' . Gates::VIEW_ADMIN_USERS], function () {
    Route::get('/webshops/create', [WebshopsController::class, 'create'])->name('super-admin.webshops.create');
    Route::post('/webshops/create', [WebshopsController::class, 'store'])->name('super-admin.webshops.store');
});

Route::group(['prefix' => 'super-admin', 'middleware' => 'can:' . Gates::EDIT_ADMIN_USERS], function () {
    Route::get('/users/{userId}/edit', [UsersController::class, 'edit'])->name('super-admin.users.edit');
    Route::post('/users/{userId}/edit', [UsersController::class, 'update'])->name('super-admin.users.update');
});

Route::group(['prefix' => 'super-admin', 'middleware' => 'can:' . Gates::READ_PACKAGES], function () {
    Route::get('/packages', [PackagesController::class, 'index'])->name('admin.packages.index');
});


Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::EDIT_WEBSHOP_USERS, ',webshop'], function () {
    Route::get('/{webshop}/users/{userId}/edit', [WebshopUsersController::class, 'edit'])->name('admin.webshop.users.edit');
    Route::post('/{webshop}/users/{userId}/edit', [WebshopUsersController::class, 'update'])->name('admin.webshop.users.update');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::READ_WEBSHOP_USERS. ',webshop'], function () {
    Route::get('/{webshop}/users', [WebshopUsersController::class, 'index'])->name('admin.webshop.users.index');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::READ_PACKAGES], function () {
    Route::get('/packages/webshop/{webshop}', [PackagesController::class, 'webshopIndex'])->name('admin.packages.webshop.index');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::READ_PACKAGES], function () {
    Route::get('/packages/calendar/{webshop}', [CalendarController::class, 'index'])->name('admin.packages.webshop.calendar');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::CREATE_PACKAGES], function () {
    Route::get('/packages/create', [PackagesController::class, 'create'])->name('admin.packages.create');
    Route::post('/packages/create', [PackagesController::class, 'store'])->name('admin.packages.store');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::MASS_IMPORT_PACKAGES], function () {
    Route::post('/package/import', [PackagesController::class, 'import'])->name('admin.packages.import');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::EDIT_PACKAGES_POST_COMPANY], function () {
    Route::post('/package/{packageId}/change-post-company', [PackagesController::class, 'changePostCompany'])->name('admin.packages.change-post-company');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::EDIT_PACKAGE_PICKUP_DATE], function () {
    Route::post('/package/{packageId}/change-pickup-time', [PackagesController::class, 'changePickupTime'])->name('admin.packages.change-pickup-time');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::CREATE_WEBSHOP_USERS . ',webshop'], function () {
    Route::get('/{webshop}/users/create', [WebshopUsersController::class, 'create'])->name('admin.webshop.users.create');
    Route::post('/{webshop}/users/create', [WebshopUsersController::class, 'store'])->name('admin.webshop.users.store');
});

Route::group(['prefix' => 'admin', 'middleware' => 'can:' . Gates::EDIT_WEBSHOP_USERS. ',webshop'], function () {
    Route::get('/{webshop}/users/{userId}/edit', [WebshopUsersController::class, 'edit'])->name('admin.webshop.users.edit');
    Route::post('/{webshop}/users/{userId}/edit', [WebshopUsersController::class, 'update'])->name('admin.webshop.users.update');
});
