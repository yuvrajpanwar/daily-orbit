<?php
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\GoogleController;


Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});



Auth::routes();

Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);


Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
    Route::put('/account/update', [App\Http\Controllers\AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/destroy', [App\Http\Controllers\AccountController::class, 'destroy'])->name('account.destroy');
    Route::post('/account/avatar-update', [App\Http\Controllers\AccountController::class, 'updateAvatar'])
    ->name('account.avatar.update');
    
});


require __DIR__.'/admin.php';