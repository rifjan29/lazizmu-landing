<?php

use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\BeritaController as FrontendBeritaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DonasiController;
use App\Http\Controllers\Backend\InformasiController;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\KategoriDonasiController;
use App\Http\Controllers\Backend\TentangKamiController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangKamiController as FrontentTentangKamiController;
use App\Http\Controllers\DonasiController as FrontentDonasiController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\WelcomeController;
use App\Models\Pengurus;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend
Route::get('/',[WelcomeController::class,'index'])->name('welcome');
Route::get('berita-frontend',[FrontendBeritaController::class,'index'])->name('frontend.berita.index');
Route::get('berita-frontend/{slug}',[FrontendBeritaController::class,'detail'])->name('frontend.berita.detail');
// Tentang Kami
Route::get('tentang-kami-frontend/latar-belakang',[FrontentTentangKamiController::class,'latarBelakang'])->name('frontend.tentang-kami.latar-belakang');
Route::get('tentang-kami-frontend/visi-misi',[FrontentTentangKamiController::class,'visiMisi'])->name('frontend.tentang-kami.visi');
Route::get('tentang-kami-frontend/keanggotaan',[FrontentTentangKamiController::class,'keanggotaan'])->name('frontend.tentang-kami.keanggotaan');
// Donasi
Route::get('donasi-frontend',[FrontentDonasiController::class,'index'])->name('frontend.donasi.index');
Route::get('donasi-frontend/{slug}',[FrontentDonasiController::class,'detail'])->name('frontend.donasi.detail');
// BACKEND
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        // kategori - Kategori donasi
        Route::resource('kategori', KategoriController::class);
        Route::resource('kategori-donasi', KategoriDonasiController::class);
        // Informasi
        Route::post('informasi/update-status',[InformasiController::class,'updatePost'])->name('informasi.updatePost');
        Route::get('informasi/update-status/{id}',[InformasiController::class,'updateDetail'])->name('informasi.updateDetail');
        Route::resource('informasi', InformasiController::class);
        // Berita
        Route::post('berita/update-status',[BeritaController::class,'updatePost'])->name('berita.updatePost');
        Route::get('berita/update-status/{id}',[BeritaController::class,'updateDetail'])->name('berita.updateDetail');
        Route::resource('berita', BeritaController::class);
        // Donasi
        Route::post('donasi/update-donasi',[DonasiController::class,'updateDonasi'])->name('donasi.updateDonasi');
        Route::get('donasi/update-donasi/{id}',[DonasiController::class,'updateDonasiDetail'])->name('donasi.updateDonasiDetail');
        Route::post('donasi/update-status',[DonasiController::class,'updatePost'])->name('donasi.updatePost');
        Route::get('donasi/update-status/{id}',[DonasiController::class,'updateDetail'])->name('donasi.updateDetail');
        Route::resource('donasi', DonasiController::class);
        // Banner
        Route::resource('banner',BannerController::class);
        //Galeri
        Route::resource('galeri',\App\Http\Controllers\Backend\GaleriController::class);
        Route::resource('user', UserController::class);
        //Tentang Kami
        Route::resource('tentang-kami',TentangKamiController::class);
        // Pengurus
        Route::resource('pengurus',PengurusController::class);
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
