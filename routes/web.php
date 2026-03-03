<?php

use App\Http\Controllers\Admin\DispatcherController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dispatcher\DispatcherController as DispatchController;
use App\Http\Controllers\DispatcherController as ControllersDispatcherController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LostFoundController;
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


    // Handle Dispatcher
    Route::get('/admin/dispatchers', [DispatcherController::class, 'index'])->name('admin.dispatchers.index');
    Route::get('/admin/dispatcher/data', [DispatcherController::class, 'getDispatchers'])->name('admin.dispatchers.data');
    Route::get('/admin/dispatchers/create', [DispatcherController::class, 'create'])->name('admin.dispatchers.create');
    Route::post('/admin/dispatchers/store', [DispatcherController::class, 'store'])->name('admin.dispatchers.store');
    Route::get('/admin/dispatchers/{id}/edit', [DispatcherController::class, 'edit'])->name('admin.dispatchers.edit');


    // Handle Drivers
    Route::get('/admin/drivers-list', [AdminDriverController::class, 'index'])->name('admin.driver.list');
    Route::get('/admin/driver/{id}/edit', [AdminDriverController::class, 'edit'])->name('admin.drivers.edit');
    Route::post('/admin/driver/{id}/update', [AdminDriverController::class, 'update'])->name('admin.drivers.update');
    Route::post('/admin/driver/{id}/updatePassword', [AdminDriverController::class, 'updatePassword'])->name('admin.drivers.updatePassword');


    // Admin Functions
    Route::get('/admin/reports', [AdminController::class, 'reportView']);
});


Route::middleware(['auth'])->group(function () {
    Route::post('/driver/dispatch', [\App\Http\Controllers\DispatcherController::class, 'dispatchDriver'])->name('driver.dispatch');
});



Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/home', [DriverController::class, 'index'])->name('driver.home');
    Route::post('/queue/check-in', [DriverController::class, 'checkIn'])->name('driver.checkin');

    // Profile
    Route::get('/driver/profile', [DriverController::class, 'viewProfile'])->name('driver.profile');
    Route::post('/driver/profile', [DriverController::class, 'updateInformation'])->name('driver.profileUpdate');
    Route::post('/driver/password', [DriverController::class, 'updatePassword'])->name('driver.passwordUpdate');

    // Trip History
    Route::get('/driver/trip-history', [DriverController::class, 'tripHistory'])->name('driver.tripHistory');

    // photos 
    Route::post('/driver/updatePhoto', [DriverController::class, 'updatePhoto'])->name('driver.updatePhoto');


    // Lost and Found

    // Route::get('/driver/lostAndFound', [DriverController::class, 'updatePhoto'])->name('driver.lostAndFound');
    // Route::get('/driver/createLostAndFound', [DriverController::class, 'updatePhoto'])->name('driver.createLostAndFound');
    // Route::get('/driver/createLostAndFound', [DriverController::class, 'updatePhoto'])->name('driver.storeLostAndFound');
});

Route::get('/LostAndFound', [LostFoundController::class, 'index'])->name('lostAndFound');
Route::get('/create-lost-and-found', [LostFoundController::class, 'createLostAndFound'])->name('createLostAndFound');
Route::post('/store-lost-and-found', [LostFoundController::class, 'store'])->name('storeLostAndFound');
Route::get('/lost-and-found/{id}', [LostFoundController::class, 'show'])->name('showLostAndFound');
Route::patch('/lost-and-found/{id}/status', [LostFoundController::class, 'updateStatus'])->name('updateLostAndFoundStatus');


// Dispatcher
Route::middleware(['auth', 'role:dispatcher'])->group(function () {
    Route::get('/dispatcher/dashboard', [DispatchController::class, 'index'])->name('dispatcher.dashboard');
});


/*
|--------------------------------------------------------------------------
| Protected Routes (after login)
|--------------------------------------------------------------------------
*/
