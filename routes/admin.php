<?php

use App\Http\Controllers\AdminControllers\BookController;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\ProfileController;
use App\Http\Controllers\AdminControllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Admin Profile
    Route::controller(ProfileController::class)
        ->prefix('admin/profile')
        ->name('admin.profile.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::put('/password', 'updatePassword')->name('password.update');
            Route::delete('/delete', 'destroy')->name('destroy');
            Route::post('/send-verification-email', 'sendVerificationEmail')->name('sendVerificationEmail');
        });

    // Admin User Management Routes
    Route::controller(UserController::class)
        ->prefix('admin/users')
        ->name('admin.users.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    
    //Admin Books Management Routes
    Route::controller(BookController::class)
        ->prefix('admin/books')
        ->name('admin.books.')
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

});