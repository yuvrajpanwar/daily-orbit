<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorController;
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
        
        


        //manage categories
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::get('/add-category', [CategoryController::class, 'addCategory'])->name('add-category');
        Route::get('/fetch-all-categories', [CategoryController::class, 'fetchAllCategories'])->name('fetch-all-categories');
        Route::post('/store-category', [CategoryController::class, 'storeCategory'])->name('store-category');
        Route::get('/edit-category/{category}', [CategoryController::class, 'editCategory'])->name('edit-category');
        Route::post('/update-category/{category}', [CategoryController::class, 'updateCategory'])->name('update-category');
        Route::post('/update-category-visibility/{category}', [CategoryController::class, 'updateCategoryVisibility'])->name('update-category-visibility');
        Route::delete('/delete-category/{category}', [CategoryController::class, 'deleteCategory'])->name('delete-category');
   

        //manage posts
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::get('/add-post', [PostController::class, 'addPost'])->name('add-post');
        Route::get('/fetch-all-posts', [PostController::class, 'fetchAllPosts'])->name('fetch-all-posts');
        Route::post('/store-post', [PostController::class, 'storePost'])->name('store-post');
        Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('upload.image');
        Route::get('/edit-post/{post}', [PostController::class, 'editPost'])->name('edit-post');
        Route::post('/update-post/{post}', [PostController::class, 'updatePost'])->name('update-post');
        Route::post('/update-post-visibility/{post}', [PostController::class, 'updatePostVisibility'])->name('update-post-visibility');
        Route::delete('/delete-post/{post}', [PostController::class, 'deletePost'])->name('delete-post');


        //manage authors
        Route::get('/authors', [AdminController::class, 'authors'])->name('authors');
        Route::get('/add-author', [AuthorController::class, 'addAuthor'])->name('add-author');
        Route::get('/fetch-all-authors', [AuthorController::class, 'fetchAllAuthors'])->name('fetch-all-authors');
        Route::post('/store-author', [AuthorController::class, 'storeAuthor'])->name('store-author');
        Route::get('/edit-author/{author}', [AuthorController::class, 'editAuthor'])->name('edit-author');
        Route::post('/update-author/{author}', [AuthorController::class, 'updateAuthor'])->name('update-author');
        Route::post('/update-author-visibility/{author}', [AuthorController::class, 'updateAuthorVisibility'])->name('update-author-visibility');
        Route::delete('/delete-post/{post}', [PostController::class, 'deletePost'])->name('delete-post');

    });
});

