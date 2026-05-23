<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

// Import Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\BeasiswaController;

// Public Pages
Route::get('/', function () {
    return Inertia::render('HomePage');
});

Route::get('/kegiatan', function () {
    return Inertia::render('ActivitiesPage');
});

Route::get('/program', function () {
    return Inertia::render('ProgramPage');
});

Route::get('/program/{slug}', function ($slug) {
    return Inertia::render('ProgramDetailPage', [
        'slug' => $slug
    ]);
});

Route::get('/kurikulum', function () {
    return Inertia::render('CurriculumPage');
});

Route::get('/kurikulum/kmi', function () {
    return Inertia::render('CurriculumDetailPage', ['type' => 'kmi']);
});

Route::get('/kurikulum/smp', function () {
    return Inertia::render('CurriculumDetailPage', ['type' => 'smp']);
});

Route::get('/kurikulum/ma', function () {
    return Inertia::render('CurriculumDetailPage', ['type' => 'ma']);
});

Route::get('/profil', function () {
    return Inertia::render('ProfilePage');
});

Route::get('/fasilitas', function () {
    return Inertia::render('FacilitiesPage');
});

Route::get('/galeri', function () {
    return Inertia::render('GalleryPage');
});

Route::get('/prestasi', function () {
    return Inertia::render('AchievementsPage');
});

Route::get('/agenda', function () {
    return Inertia::render('AgendaPage');
});

Route::get('/ikph', function () {
    $bgValue = \Illuminate\Support\Facades\DB::table('Settings')->where('key', 'ikph_background_image')->value('value');
    $bgDecoded = json_decode($bgValue, true);
    $bgImages = is_array($bgDecoded) ? $bgDecoded : ($bgValue ? [$bgValue] : []);
    
    return Inertia::render('IkphPage', ['backgroundImages' => array_values($bgImages)]);
});

Route::get('/berita', function () {
    return Inertia::render('NewsListPage');
});

Route::get('/berita/{slug}', function ($slug) {
    // We fetch the news from database dynamically to pass SEO tags to Blade header
    $news = DB::table('News')->where('slug', $slug)->first();
    
    // Share SEO metadata to the app view layout
    if ($news) {
        $siteUrl = rtrim(config('app.url', 'https://alhikmahutan.ponpes.id'), '/');
        
        $thumbnailPath = $news->thumbnail;
        if ($thumbnailPath) {
            if (str_starts_with($thumbnailPath, 'http')) {
                $thumbnail = $thumbnailPath;
            } else {
                // Ensure it has /storage/ prefix
                if (!str_starts_with($thumbnailPath, '/storage/') && !str_starts_with($thumbnailPath, 'storage/')) {
                    $thumbnailPath = '/storage/' . ltrim($thumbnailPath, '/');
                }
                $thumbnail = $siteUrl . '/' . ltrim($thumbnailPath, '/');
            }
        } else {
            $thumbnail = $siteUrl . '/og-image.jpg';
        }
            
        config(['app.seo_title' => $news->title]);
        config(['app.seo_description' => $news->excerpt]);
        config(['app.seo_image' => $thumbnail]);
        config(['app.seo_url' => url()->current()]);
    }

    return Inertia::render('NewsDetailPage');
});

Route::get('/spsb26', function () {
    return Inertia::render('RegistrationPage');
});

Route::get('/pbs26', function () {
    return Inertia::render('ScholarshipPage');
});

// API Routes
Route::prefix('api')->group(function () {
    // Public Endpoints
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'index']);
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/facilities', [\App\Http\Controllers\Api\FacilityController::class, 'index']);
    Route::get('/features', [\App\Http\Controllers\Api\FeatureController::class, 'index']);
    Route::get('/curricula', [\App\Http\Controllers\Api\CurriculumController::class, 'index']);
    Route::get('/curricula/{type}', [\App\Http\Controllers\Api\CurriculumController::class, 'show']);
    Route::get('/achievements', [\App\Http\Controllers\Api\CurriculumController::class, 'achievements']);
    Route::get('/agendas', [\App\Http\Controllers\AgendaController::class, 'index']);
    Route::get('/alumni', [\App\Http\Controllers\AlumnusController::class, 'index']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/popular', [NewsController::class, 'popular']);
    Route::get('/news/featured', [NewsController::class, 'featured']);
    Route::get('/news/slug/{slug}', [NewsController::class, 'showBySlug']);
    Route::post('/news/{id}/share', [NewsController::class, 'share']);
    Route::post('/news/{id}/comment', [NewsController::class, 'comment']);
    Route::post('/contact', [ContactController::class, 'store']);
    Route::post('/registration', [PendaftaranController::class, 'store']);
    Route::get('/registration/status/{no_registrasi}', [PendaftaranController::class, 'checkStatus']);
    Route::post('/scholarship', [BeasiswaController::class, 'store']);
    Route::get('/scholarship/status/{no_registrasi}', [BeasiswaController::class, 'checkStatus']);
    Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('/testimonials', function () {
        return response()->json(\App\Models\Testimonial::where('is_active', true)->get());
    });
});
