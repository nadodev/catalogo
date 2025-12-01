<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/produtos/buscar', [ProductController::class, 'search'])->name('products.search');
Route::get('/produtos-mais-vistos', [ProductController::class, 'mostViewed'])->name('products.most-viewed');

// Categories
Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categorias/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Public Catalog PDF View
Route::get('/catalogo', [ProductController::class, 'viewCatalogPdf'])->name('catalog.view');

// Quotes
Route::get('/orcamento/{productSlug?}', [QuoteController::class, 'create'])->name('quotes.create');
Route::post('/orcamento', [QuoteController::class, 'store'])->name('quotes.store');

// Cart
Route::get('/carrinho', function () {
    return view('cart.index');
})->name('cart.index');
Route::get('/carrinho/finalizar', function () {
    return view('cart.checkout');
})->name('cart.checkout');
Route::post('/carrinho/orcamento', [QuoteController::class, 'storeFromCart'])->name('cart.quote');

// Favorites (apenas para usuários logados)
Route::get('/favoritos', [FavoriteController::class, 'index'])->middleware('auth')->name('favorites.index');
Route::post('/api/favoritos/{product}/toggle', [FavoriteController::class, 'toggle'])->middleware('auth')->name('favorites.toggle');
Route::delete('/api/favoritos/{product}', [FavoriteController::class, 'destroy'])->middleware('auth')->name('favorites.destroy');
Route::get('/api/favoritos/{product}/check', [FavoriteController::class, 'check'])->middleware('auth')->name('favorites.check');
Route::get('/api/favoritos/list', [FavoriteController::class, 'list'])->middleware('auth')->name('favorites.list');

// Pages
Route::get('/sobre', [PageController::class, 'about'])->name('pages.about');
Route::get('/contato', [PageController::class, 'contact'])->name('pages.contact');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/cadastro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/cadastro', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard (Protected)
Route::middleware('auth')->prefix('minha-conta')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/perfil', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/pedidos', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/favoritos', [UserDashboardController::class, 'favorites'])->name('favorites');
});

// Admin Dashboard (Protected - Admin Only)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Redirect /admin to dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Products CRUD
    Route::delete('products/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::get('products/export-pdf', [AdminProductController::class, 'exportPdf'])->name('products.export-pdf');
    Route::resource('products', AdminProductController::class);

    // Categories CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Quotes CRUD
    Route::get('quotes', [AdminQuoteController::class, 'index'])->name('quotes.index');
    Route::get('quotes/{quote}', [AdminQuoteController::class, 'show'])->name('quotes.show');
    Route::put('quotes/{quote}/status', [AdminQuoteController::class, 'updateStatus'])->name('quotes.update-status');
    Route::delete('quotes/{quote}', [AdminQuoteController::class, 'destroy'])->name('quotes.destroy');
});
