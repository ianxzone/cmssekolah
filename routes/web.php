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
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\OnboardingController;
use App\Http\Controllers\Admin\AuthController;

// Admin Auth Routes
Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Protected Admin Routes
Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Onboarding Routes
    Route::get('onboarding', [OnboardingController::class, 'index'])->name('admin.onboarding.index');
    Route::post('onboarding/save', [OnboardingController::class, 'save'])->name('admin.onboarding.save');
    Route::get('onboarding/skip', [OnboardingController::class, 'skip'])->name('admin.onboarding.skip');
    Route::resource('pages', AdminPageController::class)->names('admin.pages');
    Route::resource('forms', AdminFormController::class)->names('admin.forms');
    Route::get('media/list', [AdminMediaController::class, 'apiList'])->name('admin.media.list');
    Route::resource('media', AdminMediaController::class)->only(['index', 'store', 'destroy'])->names('admin.media');
    Route::resource('categories', AdminCategoryController::class)->names('admin.categories');
    Route::resource('posts', AdminPostController::class)->names('admin.posts');
    Route::resource('events', AdminEventController::class)->names('admin.events');
    Route::resource('testimonials', AdminTestimonialController::class)->names('admin.testimonials');

    // Configs/Settings Route
    Route::get('settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

    // About/Developer Page
    Route::get('about', [DashboardController::class, 'about'])->name('admin.about');
});

use App\Http\Controllers\FrontendController;

// --- Public Frontend Routes ---
// Installation Routes
Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [App\Http\Controllers\InstallController::class, 'index'])->name('index');
    Route::get('/requirements', [App\Http\Controllers\InstallController::class, 'requirements'])->name('requirements');
    Route::get('/environment', [App\Http\Controllers\InstallController::class, 'environment'])->name('environment');
    Route::post('/environment', [App\Http\Controllers\InstallController::class, 'saveEnvironment'])->name('environment.save');
    Route::get('/database', [App\Http\Controllers\InstallController::class, 'database'])->name('database');
    Route::post('/run', [App\Http\Controllers\InstallController::class, 'runMigration'])->name('run');
    Route::get('/admin', [App\Http\Controllers\InstallController::class, 'admin'])->name('admin');
    Route::post('/admin', [App\Http\Controllers\InstallController::class, 'saveAdmin'])->name('admin.save');
    Route::get('/finish', [App\Http\Controllers\InstallController::class, 'finish'])->name('finish');
});

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/berita', [FrontendController::class, 'posts'])->name('posts.index');
Route::get('/berita/{slug}', [FrontendController::class, 'showPost'])->name('posts.show');
Route::get('/agenda', [FrontendController::class, 'events'])->name('events.index');
Route::get('/agenda/{event}', [FrontendController::class, 'showEvent'])->name('events.show');
Route::get('/category/{slug}', [FrontendController::class, 'showCategory'])->name('categories.show');

// Dynamic Forms
Route::get('/form/{slug}', [FrontendController::class, 'showForm'])->name('forms.show.frontend');
Route::post('/form/{slug}/submit', [FrontendController::class, 'submitForm'])->name('forms.submit');
