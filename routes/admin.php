<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Admin protected routes
    Route::middleware('onlyAdmin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    });
    
});

