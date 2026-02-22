<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\QueueController;
use App\Models\DriverInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Welcome
Route::view('/', 'welcome');

// Login
// Route::get('/signup', [AuthController::class, 'showRegistrationForm'])->name('signup');

// // Dispatcher signup
// Route::get('/signup/dispatcher', [AuthController::class, 'showDispatcherForm'])->name('signup.dispatcher');
//  Route::post('/signup/dispatcher', [AuthController::class, 'registerDispatcher']);

// Driver signup
Route::get('/signup', [AuthController::class, 'showDriverForm'])->name('signup');
Route::post('/signup/driver', [AuthController::class, 'registerDriver'])->name('signup.driver');




// Login / Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});


Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/home', [DriverController::class, 'index'])->name('driver.home');
    Route::post('/queue/check-in', [DriverController::class, 'checkIn'])->name('driver.checkin');
});


/*
|--------------------------------------------------------------------------
| Protected Routes (after login)
|--------------------------------------------------------------------------
*/

