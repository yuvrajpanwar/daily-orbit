<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerificationController;

// use App\Http\Controllers\Auth\GoogleController;


Route::get('/', function () {
    return view('home');
});

Route::any('/coming-soon', function () {
    return view('coming-soon');
})->name('coming-soon');

Route::get('/about', function () {
    return view('about');
});

// post details 
Route::get('/post/{slug}', [App\Http\Controllers\PostController::class, 'postDetials'])->name('post.details');


Auth::routes();

Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);


Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
    Route::put('/account/update', [App\Http\Controllers\AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/destroy', [App\Http\Controllers\AccountController::class, 'destroy'])->name('account.destroy');
    Route::post('/account/avatar-update', [App\Http\Controllers\AccountController::class, 'updateAvatar'])->name('account.avatar.update');
    Route::post('/send-verification-link', [EmailVerificationController::class, 'sendLink'])->name('verification.send');
    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});


require __DIR__ . '/admin.php';
