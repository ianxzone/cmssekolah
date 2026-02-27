<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\FormController as AdminFormController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;

Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('pages', AdminPageController::class)->names('admin.pages');
    Route::resource('forms', AdminFormController::class)->names('admin.forms');
    Route::resource('media', AdminMediaController::class)->only(['index', 'store', 'destroy']);
    Route::resource('categories', AdminCategoryController::class)->names('admin.categories');
    Route::resource('posts', AdminPostController::class)->names('admin.posts');
});

use App\Http\Controllers\FrontendController;

// --- Public Frontend Routes ---
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/post/{slug}', [FrontendController::class, 'showPost'])->name('posts.show');
Route::get('/category/{slug}', [FrontendController::class, 'showCategory'])->name('categories.show');

// Dynamic Forms
Route::get('/form/{slug}', [FrontendController::class, 'showForm'])->name('forms.show.frontend');
Route::post('/form/{slug}/submit', [FrontendController::class, 'submitForm'])->name('forms.submit');
