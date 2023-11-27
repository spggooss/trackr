<?php

use App\Http\Controllers\Web\User\CalenderController;
use Illuminate\Support\Facades\Route;

Route::get('calendar-event', [CalenderController::class, 'index'])->middleware('auth');
