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
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\BiolinkController as AdminBiolinkController;
use App\Http\Controllers\Admin\GuestBookController as AdminGuestBookController;
use App\Http\Controllers\Admin\WordPressImportController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\BiolinkController;
use App\Http\Controllers\GuestBookController;

Route::prefix('admin')->middleware(['web'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('pages', AdminPageController::class)->names('admin.pages');
    Route::resource('forms', AdminFormController::class)->names('admin.forms');
    Route::get('media/list', [AdminMediaController::class, 'apiList'])->name('admin.media.list');
    Route::put('media/{media}', [AdminMediaController::class, 'apiUpdate'])->name('admin.media.update');
    Route::resource('media', AdminMediaController::class)->only(['index', 'store', 'destroy'])->names('admin.media');
    Route::resource('categories', AdminCategoryController::class)->names('admin.categories');
    Route::resource('posts', AdminPostController::class)->names('admin.posts');
    Route::resource('events', AdminEventController::class)->names('admin.events');
    Route::resource('teachers', AdminTeacherController::class)->names('admin.teachers');
    Route::resource('testimonials', AdminTestimonialController::class)->names('admin.testimonials');

    // Biolink Routes
    Route::get('biolink', [AdminBiolinkController::class, 'index'])->name('admin.biolink.index');
    Route::post('biolink/profile', [AdminBiolinkController::class, 'updateProfile'])->name('admin.biolink.profile.update');
    Route::post('biolink/sections', [AdminBiolinkController::class, 'storeSection'])->name('admin.biolink.sections.store');
    Route::put('biolink/sections/{section}', [AdminBiolinkController::class, 'updateSection'])->name('admin.biolink.sections.update');
    Route::delete('biolink/sections/{section}', [AdminBiolinkController::class, 'destroySection'])->name('admin.biolink.sections.destroy');
    Route::post('biolink/links', [AdminBiolinkController::class, 'storeLink'])->name('admin.biolink.links.store');
    Route::put('biolink/links/{link}', [AdminBiolinkController::class, 'updateLink'])->name('admin.biolink.links.update');
    Route::delete('biolink/links/{link}', [AdminBiolinkController::class, 'destroyLink'])->name('admin.biolink.links.destroy');

    // Guest Book / Buku Tamu Routes
    Route::get('guestbook', [AdminGuestBookController::class, 'index'])->name('admin.guestbook.index');
    Route::post('guestbook/settings', [AdminGuestBookController::class, 'updateSettings'])->name('admin.guestbook.settings.update');
    Route::post('guestbook/services', [AdminGuestBookController::class, 'storeService'])->name('admin.guestbook.services.store');
    Route::put('guestbook/services/{service}', [AdminGuestBookController::class, 'updateService'])->name('admin.guestbook.services.update');
    Route::delete('guestbook/services/{service}', [AdminGuestBookController::class, 'destroyService'])->name('admin.guestbook.services.destroy');
    Route::patch('guestbook/entries/{entry}/status', [AdminGuestBookController::class, 'updateEntryStatus'])->name('admin.guestbook.entries.status');
    Route::delete('guestbook/entries/{entry}', [AdminGuestBookController::class, 'destroyEntry'])->name('admin.guestbook.entries.destroy');
    Route::get('guestbook/export', [AdminGuestBookController::class, 'exportEntries'])->name('admin.guestbook.export');

    // WordPress Import
    Route::get('wordpress-import', [WordPressImportController::class, 'index'])->name('admin.wordpress-import.index');
    Route::post('wordpress-import/preview', [WordPressImportController::class, 'preview'])->name('admin.wordpress-import.preview');
    Route::post('wordpress-import/import', [WordPressImportController::class, 'import'])->name('admin.wordpress-import.import');

    // Redirects (SEO)
    Route::get('redirects', [RedirectController::class, 'index'])->name('admin.redirects.index');
    Route::post('redirects', [RedirectController::class, 'store'])->name('admin.redirects.store');
    Route::put('redirects/{redirect}', [RedirectController::class, 'update'])->name('admin.redirects.update');
    Route::delete('redirects/{redirect}', [RedirectController::class, 'destroy'])->name('admin.redirects.destroy');

    // Post Comments Moderation
    Route::get('comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
    Route::patch('comments/{comment}/status', [AdminCommentController::class, 'updateStatus'])->name('admin.comments.status');
    Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');

    // Configs/Settings Route
    Route::get('settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
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
Route::get('/agenda', [FrontendController::class, 'events'])->name('events.index');
Route::get('/agenda/{event}', [FrontendController::class, 'showEvent'])->name('events.show');
Route::get('/testimoni', [FrontendController::class, 'testimonials'])->name('testimonials.index');
Route::get('/kurikulum-khas', [FrontendController::class, 'kurikulum'])->name('kurikulum.index');
Route::get('/fasilitas', [FrontendController::class, 'fasilitas'])->name('fasilitas.index');
Route::get('/pearson-icp', [FrontendController::class, 'pearson'])->name('pearson.index');
Route::get('/category/{slug}', [FrontendController::class, 'showCategory'])->name('categories.show');

// Dynamic Forms
Route::get('/form/{slug}', [FrontendController::class, 'showForm'])->name('forms.show.frontend');
Route::post('/form/{slug}/submit', [FrontendController::class, 'submitForm'])->name('forms.submit');

// Biolink Public Routes
Route::get('/links', [BiolinkController::class, 'index'])->name('biolink.show');
Route::get('/biolink', [BiolinkController::class, 'index'])->name('biolink.alias');
Route::get('/links/click/{id}', [BiolinkController::class, 'click'])->name('biolink.click');

// Buku Tamu Public Routes
Route::get('/buku-tamu', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::post('/buku-tamu', [GuestBookController::class, 'store'])->name('guestbook.store');
Route::get('/buku-tamu/click/{id}', [GuestBookController::class, 'click'])->name('guestbook.click');

// SEO Routes
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [FrontendController::class, 'robots'])->name('robots');

// Post Comment Submission
Route::post('/{slug}/komentar', [FrontendController::class, 'storeComment'])->name('posts.comments.store');

// Catch-all: Post slug first, then Page slug
Route::get('/{slug}', [FrontendController::class, 'showSlug'])->name('posts.show');
