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
use App\Http\Controllers\Admin\RankMathImportController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\BiolinkController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\SecurityController as AdminSecurityController;

$adminPath = config('app.admin_path', 'admin');
try {
    if (\Illuminate\Support\Facades\DB::connection()->getPdo() && \Illuminate\Support\Facades\Schema::hasTable('settings')) {
        $dbAdminPath = \Illuminate\Support\Facades\DB::table('settings')->where('key', 'admin_path')->value('value');
        if (!empty($dbAdminPath)) {
            $adminPath = $dbAdminPath;
        }
    }
} catch (\Throwable $e) {
    // Fallback to config if DB is not ready
}

// Public Admin Auth Routes
Route::prefix($adminPath)->middleware(['web'])->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Protected Admin Routes (Authenticated Only)
Route::prefix($adminPath)->middleware(['web', 'auth'])->group(function () {
    
    // Group 1: All Authenticated Backend Users (Admin, Editor, Author, Contributor)
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/about', [DashboardController::class, 'about'])->name('admin.about');
    Route::resource('posts', AdminPostController::class)->names('admin.posts');
    Route::get('media/list', [AdminMediaController::class, 'apiList'])->name('admin.media.list');
    Route::put('media/{media}', [AdminMediaController::class, 'apiUpdate'])->name('admin.media.update');
    Route::resource('media', AdminMediaController::class)->only(['index', 'store', 'destroy'])->names('admin.media');

    // Group 2: Admin & Editor only
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('pages', AdminPageController::class)->names('admin.pages');
        Route::resource('categories', AdminCategoryController::class)->names('admin.categories');
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

        // Post Comments Moderation
        Route::get('comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
        Route::patch('comments/{comment}/status', [AdminCommentController::class, 'updateStatus'])->name('admin.comments.status');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');

        // Alumni Management
        Route::get('alumni', [AdminAlumniController::class, 'index'])->name('admin.alumni.index');
        Route::post('alumni/angkatan', [AdminAlumniController::class, 'storeAngkatan'])->name('admin.alumni.angkatan.store');
        Route::put('alumni/angkatan/{id}', [AdminAlumniController::class, 'updateAngkatan'])->name('admin.alumni.angkatan.update');
        Route::delete('alumni/angkatan/{id}', [AdminAlumniController::class, 'destroyAngkatan'])->name('admin.alumni.angkatan.destroy');
        Route::post('alumni/video', [AdminAlumniController::class, 'storeVideo'])->name('admin.alumni.video.store');
        Route::put('alumni/video/{id}', [AdminAlumniController::class, 'updateVideo'])->name('admin.alumni.video.update');
        Route::delete('alumni/video/{id}', [AdminAlumniController::class, 'destroyVideo'])->name('admin.alumni.video.destroy');
        Route::post('alumni/settings', [AdminAlumniController::class, 'updateSettings'])->name('admin.alumni.settings.update');
    });

    // Group 3: Admin only (Settings, Security, Forms, Guestbook, Redirects, Imports, Users)
    Route::middleware('role:admin')->group(function () {
        // Users Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
        // Forms & Submissions (PII data)
        Route::get('forms/{form}/export', [AdminFormController::class, 'export'])->name('admin.forms.export');
        Route::get('forms/{form}/download', [AdminFormController::class, 'downloadAttachment'])->name('admin.forms.download');
        Route::resource('forms', AdminFormController::class)->names('admin.forms');

        // Guest Book / Buku Tamu Routes
        Route::get('guestbook', [AdminGuestBookController::class, 'index'])->name('admin.guestbook.index');
        Route::post('guestbook/settings', [AdminGuestBookController::class, 'updateSettings'])->name('admin.guestbook.settings.update');
        Route::post('guestbook/services', [AdminGuestBookController::class, 'storeService'])->name('admin.guestbook.services.store');
        Route::put('guestbook/services/{service}', [AdminGuestBookController::class, 'updateService'])->name('admin.guestbook.services.update');
        Route::delete('guestbook/services/{service}', [AdminGuestBookController::class, 'destroyService'])->name('admin.guestbook.services.destroy');
        Route::patch('guestbook/entries/{entry}/status', [AdminGuestBookController::class, 'updateEntryStatus'])->name('admin.guestbook.entries.status');
        Route::delete('guestbook/entries/{entry}', [AdminGuestBookController::class, 'destroyEntry'])->name('admin.guestbook.entries.destroy');
        Route::get('guestbook/export', [AdminGuestBookController::class, 'exportEntries'])->name('admin.guestbook.export');

    });

    // Group 4: Superadmin only (Imports)
    Route::middleware('role:superadmin')->group(function () {
        // WordPress Import
        Route::get('wordpress-import', [WordPressImportController::class, 'index'])->name('admin.wordpress-import.index');
        Route::post('wordpress-import/preview', [WordPressImportController::class, 'preview'])->name('admin.wordpress-import.preview');
        Route::post('wordpress-import/import', [WordPressImportController::class, 'import'])->name('admin.wordpress-import.import');

        // Rank Math SEO Import
        Route::get('rankmath-import', [RankMathImportController::class, 'index'])->name('admin.rankmath-import.index');
        Route::post('rankmath-import/preview', [RankMathImportController::class, 'preview'])->name('admin.rankmath-import.preview');
        Route::post('rankmath-import/import', [RankMathImportController::class, 'import'])->name('admin.rankmath-import.import');

        // Redirects (SEO)
        Route::get('redirects', [RedirectController::class, 'index'])->name('admin.redirects.index');
        Route::post('redirects', [RedirectController::class, 'store'])->name('admin.redirects.store');
        Route::get('redirects/export', [RedirectController::class, 'export'])->name('admin.redirects.export');
        Route::post('redirects/import', [RedirectController::class, 'import'])->name('admin.redirects.import');
        Route::patch('redirects/{redirect}/toggle', [RedirectController::class, 'toggle'])->name('admin.redirects.toggle');
        Route::put('redirects/{redirect}', [RedirectController::class, 'update'])->name('admin.redirects.update');
        Route::delete('redirects/{redirect}', [RedirectController::class, 'destroy'])->name('admin.redirects.destroy');

        // Configs/Settings Route
        Route::get('settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

        // Security Center & Monitoring Routes
        Route::get('security', [AdminSecurityController::class, 'index'])->name('admin.security.index');
        Route::post('security/ip', [AdminSecurityController::class, 'blockIp'])->name('admin.security.ip.store');
        Route::delete('security/ip/{id}', [AdminSecurityController::class, 'unblockIp'])->name('admin.security.ip.destroy');
        Route::post('security/threats/clear', [AdminSecurityController::class, 'clearThreatLogs'])->name('admin.security.threats.clear');
        Route::post('security/settings', [AdminSecurityController::class, 'updateSettings'])->name('admin.security.settings.update');
    });
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
Route::get('/blog', [FrontendController::class, 'posts'])->name('posts.index');
Route::redirect('/berita', '/blog', 301);
Route::get('/blog/page/{page}', function ($page) {
    return redirect('/blog?page=' . $page, 301);
});
Route::get('/agenda', [FrontendController::class, 'events'])->name('events.index');
Route::get('/agenda/{event}', [FrontendController::class, 'showEvent'])->name('events.show');
Route::get('/testimoni', [FrontendController::class, 'testimonials'])->name('testimonials.index');
Route::get('/kurikulum-khas', [FrontendController::class, 'kurikulum'])->name('kurikulum.index');
Route::get('/fasilitas', [FrontendController::class, 'fasilitas'])->name('fasilitas.index');
Route::get('/ekstrakurikuler', [FrontendController::class, 'ekskul'])->name('ekskul.index');
Route::get('/pearson-icp', [FrontendController::class, 'pearson'])->name('pearson.index');
Route::get('/category/{slug}', [FrontendController::class, 'showCategory'])->name('categories.show');

// Dynamic Forms
Route::get('/form/{slug}', [FrontendController::class, 'showForm'])->name('forms.show.frontend');
Route::post('/form/{slug}/submit', [FrontendController::class, 'submitForm'])->middleware('throttle:15,1')->name('forms.submit');

// Biolink Public Routes
Route::get('/links', [BiolinkController::class, 'index'])->name('biolink.show');
Route::get('/biolink', [BiolinkController::class, 'index'])->name('biolink.alias');
Route::get('/links/click/{id}', [BiolinkController::class, 'click'])->middleware('throttle:30,1')->name('biolink.click');

// Buku Tamu Public Routes
Route::get('/buku-tamu', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::post('/buku-tamu', [GuestBookController::class, 'store'])->middleware('throttle:10,1')->name('guestbook.store');
Route::get('/buku-tamu/click/{id}', [GuestBookController::class, 'click'])->middleware('throttle:30,1')->name('guestbook.click');

// Alumni Public Route
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');

// SEO Routes
Route::redirect('/sitemap.xml', '/sitemap_index.xml', 301);
Route::get('/sitemap_index.xml', [FrontendController::class, 'sitemapIndex'])->name('sitemap.index');
Route::get('/post-sitemap.xml', [FrontendController::class, 'sitemapPosts'])->name('sitemap.posts');
Route::get('/page-sitemap.xml', [FrontendController::class, 'sitemapPages'])->name('sitemap.pages');
Route::get('/category-sitemap.xml', [FrontendController::class, 'sitemapCategories'])->name('sitemap.categories');
Route::get('/agenda-sitemap.xml', [FrontendController::class, 'sitemapEvents'])->name('sitemap.events');
Route::get('/robots.txt', [FrontendController::class, 'robots'])->name('robots');

// Post Comment Submission
Route::post('/{slug}/komentar', [FrontendController::class, 'storeComment'])->middleware('throttle:10,1')->name('posts.comments.store');

// Catch-all: Post slug first, then Page slug
Route::get('/{slug}', [FrontendController::class, 'showSlug'])->name('posts.show');
