<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, HomeController, CartController, CheckoutController, ContactController, ProfileController};
use App\Http\Controllers\Admin\{DashboardController, CategoryController, BookController, UserController, OrderController, MessageController};

// ---------- Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books/{book}', [HomeController::class, 'show'])->name('books.show');
Route::view('/about', 'about')->name('about');

// ---------- Auth ----------
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---------- User ----------
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [CheckoutController::class, 'history'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/proof', [CheckoutController::class, 'uploadProof'])->name('orders.proof');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

// ---------- Admin ----------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('books', BookController::class)->except('show');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
});
