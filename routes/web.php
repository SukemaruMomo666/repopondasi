<?php

use Illuminate\Support\Facades\Route;

// --- IMPORT CONTROLLER UTAMA ---
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ChatAiController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ChatController; // <-- CHAT UNTUK CUSTOMER DI FRONTEND

// --- IMPORT CONTROLLER SELLER ---
// (Hanya disisakan untuk kebutuhan banding akun jika user/seller menggunakan form dari depan)
use App\Http\Controllers\SellerController;

/*
|--------------------------------------------------------------------------
| Web Routes - Pondasikita Customer & Public
|--------------------------------------------------------------------------
*/

// 1. LANDING PAGE & FRONTEND DETAIL
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/produk/{slug}', [FrontProductController::class, 'detail'])->name('produk.detail');

// 2. CUSTOMER JOURNEY (GROUPED)
Route::controller(PageController::class)->group(function () {
    // Katalog & Toko
    Route::get('/pages/produk', 'produk')->name('produk.index');
    Route::get('/pages/semua_toko', 'semuaToko')->name('toko.index');
    Route::get('/pages/toko', 'detailToko')->name('toko.detail');
    Route::get('/pages/search', 'search')->name('search');

    Route::post('/api/toko/follow', 'toggleFollow')->name('api.toko.follow');

    // Route untuk menampilkan halaman (Link yang dipanggil di halaman Login)
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    // Route untuk menangani submit form email
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // Keranjang Belanja
    Route::get('/pages/keranjang', 'keranjang')->name('keranjang.index');
    Route::post('/api/keranjang/tambah', 'tambahKeranjang')->name('keranjang.tambah');
    Route::post('/api/keranjang/update', 'updateKeranjang')->name('keranjang.update');
    Route::post('/api/keranjang/hapus', 'hapusKeranjang')->name('keranjang.hapus');

    Route::middleware(['auth'])->group(function () {
        // Rute untuk tombol "+ Keranjang" (AJAX JSON)
        Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');

        // Rute untuk tombol "Beli Sekarang" (Form Submit)
        Route::post('/checkout/langsung', [KeranjangController::class, 'checkoutLangsung'])->name('checkout.langsung');
    });

    // Checkout
    Route::match(['get', 'post'], '/checkout', 'checkout')->name('checkout');
    Route::post('/checkout/proses', 'prosesCheckout')->name('checkout.process');

    // Profil User
    Route::get('/profil-saya', 'profil')->name('profil.index');
    Route::get('/profil-saya/edit', 'editProfil')->name('profil.edit');
    
    // --- PERBAIKAN: RUTE FALLBACK UNTUK MENCEGAH ERROR METHOD GET SAAT REFRESH ---
    Route::get('/profil-saya/update', function() { return redirect()->route('profil.edit'); });
    // -------------------------------------------------------------------------------
    
    Route::post('/profil-saya/update', 'updateProfil')->name('profil.update');
    Route::get('/profil-saya/ganti-password', 'gantiPassword')->name('profil.password');
    Route::post('/profil-saya/ganti-password/send-otp', 'sendOtpPassword')->name('profil.password.send_otp');
    Route::post('/profil-saya/ganti-password/verify-otp', 'verifyOtpPassword')->name('profil.password.verify_otp');
    Route::post('/profil-saya/ganti-password', 'updatePassword')->name('profil.password.update');

    // =========================================================================
    // FITUR ENTERPRISE: Status Pesanan, Lacak, & Siklus Aksi Transaksi
    // =========================================================================
    Route::get('/pesanan', 'pesanan')->name('pesanan.index');
    Route::get('/pesanan/{kode_invoice}', 'lacakPesanan')->name('pesanan.lacak');

    // Aksi Interaktif Customer
    Route::post('/pesanan/batalkan', 'batalkanPesanan')->name('pesanan.batalkan');
    Route::post('/pesanan/terima', 'terimaPesanan')->name('pesanan.terima');
    Route::post('/pesanan/komplain', 'ajukanPengembalian')->name('pesanan.komplain');
    Route::post('/pesanan/review', 'submitReview')->name('pesanan.review');

    // Sinyal Realtime Midtrans (Auto-Update Status)
    Route::post('/payment/update-status', 'updatePaymentStatus')->name('payment.update_status');
    // =========================================================================
});

// Pengajuan Banding Akun (Global untuk Seller & Customer)
Route::post('/account/appeal', [App\Http\Controllers\SellerController::class, 'submitAppeal'])->name('account.appeal')->middleware('auth');

// 3. AUTHENTICATION SYSTEM
Route::controller(AuthController::class)->group(function () {
    // Customer Auth
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.process');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.process');

    // Seller Auth (Dipertahankan agar user bisa mendaftar jadi seller dari web publik)
    Route::get('/seller/login', 'showLoginSeller')->name('seller.login');
    Route::post('/seller/login', 'loginSeller')->name('seller.login.process');
    Route::get('/seller/register', 'showRegisterSeller')->name('seller.register');
    Route::post('/seller/register', 'registerSeller')->name('seller.register.process');

    Route::post('/logout', 'logout')->name('logout');
});

// 6. API, AJAX, & WEBHOOKS
Route::get('/api/biteship/search', [PageController::class, 'searchBiteshipAPI']); // <-- UPDATE API BITESHIP

Route::get('/api/cek-ongkir', [PageController::class, 'cekOngkir'])->name('api.cek.ongkir');
// Chat AI (POTA)
Route::post('/api/chat', [ChatAiController::class, 'handleChat'])->name('api.chat');

// --- RUTE CHAT CUSTOMER (HUBUNGI SELLER DARI FRONTEND) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/api/chat/contacts', [ChatController::class, 'getContacts']);
    Route::get('/api/chat/messages/{storeId}', [ChatController::class, 'getMessages']);
    Route::post('/api/chat/send', [ChatController::class, 'sendMessage']);
    
    // === TAMBAHKAN INI: ROUTE PENJAGA PINTU MEDIA PRIVATE ===
    Route::get('/chat/media/{filename}', function ($filename) {
        $path = 'private_chats/' . $filename;

        // Cek apakah filenya benar-benar ada di storage lokal?
        if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($path)) { 
            abort(404, 'File media tidak ditemukan.'); 
        }

        // Tampilkan file secara aman melalui backend
        return response()->file(storage_path('app/' . $path));
    })->name('chat.file');
    // ========================================================
});

// Webhook Midtrans (Payment Gateway) - Pengecualian CSRF Token
Route::post('/webhook/midtrans', [WebhookController::class, 'midtransHandler'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.midtrans');

// 7. EXTERNAL & UTILS
Route::get('/auth/google', [\App\Http\Controllers\AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [\App\Http\Controllers\AuthController::class, 'handleGoogleCallback']);

// ========================================================
// RUTE SAPU JAGAT (PEMBERSIH MEMORI SERVER HOSTINGER)
// ========================================================
Route::get('/bersih', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "<h1>Sapu Jagat Berhasil!</h1><p>Semua memori lama sudah dihapus. Silakan cek API sekarang.</p>";
}); 

Route::get('/buat-tabel-token-vip', function() {
    try {
        \Illuminate\Support\Facades\DB::statement("
            CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
              `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
              `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `tokenable_id` bigint(20) unsigned NOT NULL,
              `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
              `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
              `abilities` text COLLATE utf8mb4_unicode_ci,
              `last_used_at` timestamp NULL DEFAULT NULL,
              `expires_at` timestamp NULL DEFAULT NULL,
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
              KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        return 'JALUR VIP SUKSES! Tabel personal_access_tokens sudah dipaksa masuk ke database!';
    } catch (\Exception $e) {
        return 'Waduh gagal: ' . $e->getMessage();
    }
});