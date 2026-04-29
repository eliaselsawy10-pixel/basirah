<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\LensController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\ReviewController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminPrescriptionController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'Home.about')->name('about');

// Product Routes
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/category/{type}', [ProductsController::class, 'filter'])->name('products.category');
Route::get('/products/color-lenses', [ProductsController::class, 'colorLenses'])->name('products.color-lenses');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');

Route::get('/select-lenses/{id}', [LensController::class, 'selectLenses'])->name('lenses.select');
Route::post('/select-lenses/proceed', [LensController::class, 'proceedToCheckout'])->name('lenses.proceed');

// Consultation / Appointment Routes (public — browse doctors & check slots)
Route::get('/consultations', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/slots', [AppointmentController::class, 'availableSlots'])->name('appointments.slots');

// Doctor Dashboard (requires auth — checked inside controller)
Route::get('/doctor/dashboard', [AppointmentController::class, 'doctorDashboard'])->name('doctor.dashboard')->middleware('auth');


// Cart Routes (browsing allowed for guests)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Checkout Routes (requires auth — payment processing)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/confirmation/{id}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

    // Order History Routes
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Appointment Routes (requires auth — book, pay, view)
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/checkout', [AppointmentController::class, 'checkout'])->name('appointments.checkout');
    Route::post('/appointments/checkout', [AppointmentController::class, 'processCheckout'])->name('appointments.processCheckout');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
    Route::get('/consultation/join/{token}', [AppointmentController::class, 'joinMeeting'])->name('consultation.join');

    // Prescription Routes (requires auth for anti-duplicate user_id logic)
    Route::get('/prescription/create', [PrescriptionController::class, 'create'])->name('prescription.create');
    Route::post('/prescription/ocr', [PrescriptionController::class, 'ocr'])->name('prescription.ocr');
    Route::post('/prescription/store', [PrescriptionController::class, 'storeManual'])->name('prescription.storeManual');

    // Favorites Routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // User Settings Routes
    Route::get('/settings', [UserSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [UserSettingsController::class, 'update'])->name('settings.update');

    // Reviews Route
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// ═══════════════════════════════════════════════
// Admin Dashboard Routes
// ═══════════════════════════════════════════════
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products CRUD
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Appointments
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{id}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    // Reviews
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Prescriptions
    Route::get('/prescriptions', [AdminPrescriptionController::class, 'index'])->name('prescriptions.index');
});
