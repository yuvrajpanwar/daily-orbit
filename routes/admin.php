<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Admin protected routes
    Route::middleware('onlyAdmin')->group(function () {

        // go to page
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');



        //manage categories
        Route::get('/add-category', [CategoryController::class, 'addCategory'])->name('add-category');
        Route::get('/fetch-all-categories', [CategoryController::class, 'fetchAllCategories'])->name('fetch-all-categories');
        Route::post('/store-category', [CategoryController::class, 'storeCategory'])->name('store-category');
        Route::get('/edit-category/{category}', [CategoryController::class, 'editCategory'])->name('edit-category');
        Route::post('/update-category-visibility/{category}', [CategoryController::class, 'updateCategoryVisibility'])->name('update-category-visibility');
        Route::delete('/delete-category/{category}', [CategoryController::class, 'deleteCategory'])->name('delete-category');
   
    });
    
});

