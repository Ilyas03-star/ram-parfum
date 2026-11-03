<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

// Hak Akses Publik
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/contact', function() { return view('contact'); })->name('contact');

// Autentikasi
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus user login & Admin
Route::middleware(['auth'])->group(function () {
    // Rute Checkout & Upload Bukti Pembayaran QRIS
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/upload-proof', [OrderController::class, 'uploadProof'])->name('upload.proof');
    Route::post('/order/upload-proof', [OrderController::class, 'uploadProof'])->name('order.uploadProof'); // Menjaga kompatibilitas nama route form view pembayaran
    
    // Route Khusus Admin (Hanya bisa diakses jika role = admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
    });
    
});
// Di dalam group admin (routes/web.php)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    
    // Rute untuk update status pesanan oleh admin
    Route::post('/orders/{order}/update-status', [DashboardController::class, 'updateOrderStatus'])->name('orders.updateStatus');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/upload-proof', [OrderController::class, 'uploadProof'])->name('upload.proof');
    Route::post('/order/upload-proof', [OrderController::class, 'uploadProof'])->name('order.uploadProof');
    
    // Rute Riwayat Pesanan / Keranjang Pembeli
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.myOrders');
    Route::post('/order/{order}/complete', [OrderController::class, 'markAsComplete'])->name('orders.complete');
});