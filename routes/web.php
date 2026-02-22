<?php

use App\Http\Controllers\Admin\DispatcherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dispatcher\DispatcherController as DispatchController;
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



Route::get('/admin/dispatchers', [DispatcherController::class, 'index'])->name('admin.dispatchers.index');
Route::get('/admin/dispatcher/data', [DispatcherController::class, 'getDispatchers'])->name('admin.dispatchers.data');
Route::get('/admin/dispatchers/create', [DispatcherController::class, 'create'])->name('admin.dispatchers.create');
Route::post('/admin/dispatchers/store', [DispatcherController::class, 'store'])->name('admin.dispatchers.store');



Route::get('/admin/driver', [AdminController::class, 'driverView']);
Route::get('/admin/reports', [AdminController::class, 'reportView']);
});


Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/home', [DriverController::class, 'index'])->name('driver.home');
    Route::post('/queue/check-in', [DriverController::class, 'checkIn'])->name('driver.checkin');
});


Route::middleware(['auth', 'role:dispatcher'])->group(function () {
    Route::get('/dispatcher/dashboard', [DispatchController::class, 'index'])->name('dispatcher.dashboard');
});


/*
|--------------------------------------------------------------------------
| Protected Routes (after login)
|--------------------------------------------------------------------------
*/
