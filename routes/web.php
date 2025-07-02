<?php

use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\UserControllers\HomeController;
use App\Http\Controllers\UserControllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome')->middleware('guest');

Route::middleware('auth', 'user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::controller(ProfileController::class)->prefix('user/profile')->name('user.profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::put('/password', 'updatePassword')->name('password.update');
        Route::delete('/delete', 'destroy')->name('destroy');
        Route::post('/send-verification-email', 'sendVerificationEmail')->name('sendVerificationEmail');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function () {
        Auth::user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
