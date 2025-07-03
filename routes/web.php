<?php

use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\UserControllers\HomeController;
use App\Http\Controllers\UserControllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\UserControllers\BookController;
use App\Http\Controllers\FeedbackController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome')->middleware('guest');

Route::middleware('auth', 'user')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Profile Routes
    Route::controller(ProfileController::class)
        ->prefix('user/profile')
        ->name('user.profile.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::put('/password', 'updatePassword')->name('password.update');
            Route::delete('/delete', 'destroy')->name('destroy');
            Route::post('/send-verification-email', 'sendVerificationEmail')->name('sendVerificationEmail');
    });

    //Book Routes
    Route::get('/books',[BookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.view');
    Route::get('/books/{id}/read', [BookController::class, 'read'])->name('books.read');
    Route::post('/books/{id}/progress', [\App\Http\Controllers\UserControllers\BookController::class, 'saveProgress'])->name('books.saveProgress');

    //Feedback Routes
    Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/my-feedback', [FeedbackController::class, 'myFeedback'])->name('feedback.my');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function () {
        Auth::user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');

});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
