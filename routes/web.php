<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\MenuSubmissionController;
use App\Http\Controllers\Manager\OrderController as ManagerOrderController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\MenuController as UserMenuController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ProfileController;

// ============================================
// HALAMAN PUBLIK
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================
// AUTHENTICATION (MANUAL - TANPA LARAVEL/UI)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============================================
// ROUTE ADMIN (Role: admin)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Kategori
    Route::resource('categories', CategoryController::class);
    
    // Manajemen Menu (CRUD)
    Route::resource('menus', MenuController::class);
    
    // Manajemen User
    Route::resource('users', UserController::class);
    
    // Approve/Reject Menu dari Manager
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{menu}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{menu}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
    
    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Lihat Semua Transaksi
    Route::get('/transactions', [ReportController::class, 'transactions'])->name('transactions.index');
});

// ============================================
// ROUTE MANAGER (Role: manager)
// ============================================
Route::middleware(['auth', 'manager'])->prefix('manager')->name('manager.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Menu (dengan status pending)
    Route::resource('menus', MenuSubmissionController::class);
    
    // Manajemen Order/Pesanan
    Route::get('/orders', [ManagerOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/accept', [ManagerOrderController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/{order}/reject', [ManagerOrderController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{order}/process', [ManagerOrderController::class, 'process'])->name('orders.process');
    Route::post('/orders/{order}/complete', [ManagerOrderController::class, 'complete'])->name('orders.complete');
    
    // Lihat Detail Menu
    Route::get('/menus/{menu}/show', [MenuSubmissionController::class, 'show'])->name('menus.show');
});

// ============================================
// ROUTE USER (Role: user)
// ============================================
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Lihat Menu (yang sudah approved)
    Route::get('/menus', [UserMenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/{menu}', [UserMenuController::class, 'show'])->name('menus.show');
    
    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // Riwayat Pesanan
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Batalkan Pesanan
    Route::post('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
});

// ============================================
// ROUTE TESTING (HAPUS NANTI)
// ============================================
Route::get('/test', function () {
    return view('test');
})->name('test');

// ============================================
// FALLBACK ROUTE (404)
// ============================================
Route::fallback(function () {
    return view('errors.404');
});