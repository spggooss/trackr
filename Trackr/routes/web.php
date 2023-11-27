<?php

use App\Auth\Gates;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LanguageController;
use App\Http\Controllers\Web\Packages\LabelController;
use App\Http\Controllers\Web\Packages\PackagesController;
use App\Http\Controllers\Web\Packages\ReviewController;
use App\Http\Controllers\Web\User\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('user.package.search') ;
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/packages', [PackagesController::class, 'packagesForUser'])->name('user.packages.index');
    Route::get('/package/review/{packageId}', [ReviewController::class, 'index'])->name('packages.review');
    Route::post('/package/review', [ReviewController::class, 'store'])->name('packages.review.store');
    Route::post('/package/add-to-account', [PackagesController::class, 'addPackageToAccount'])->name('packages.add-to-account');
});



Route::get('/packages/{packageId}', [PackagesController::class, 'show'])->name('packages.show');
Route::get('/package/show-by-trace-code', [PackagesController::class, 'findPackage'])->name('packages.find-package');




Route::group(['middleware' => 'can:' . Gates::GET_PACKAGE_LABELS], function () {
    Route::post('/label/generate-all', [LabelController::class, 'generateLabels'])->name('label.generate.all');
    Route::post('/label/generate', [LabelController::class, 'generateLabel'])->name('label.generate');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
