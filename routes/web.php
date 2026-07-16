<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\WebProductoController;
use App\Http\Controllers\Admin\WebClienteController;
use App\Http\Controllers\Admin\WebPedidoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebBannerController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Store\RegisterController;
use App\Http\Controllers\Store\CustomerController;
use App\Http\Controllers\Store\CheckoutController;

// --- RUTAS PÚBLICAS ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/producto/{producto:slug}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

// --- PANEL ADMINISTRATIVO (RESTAURADO AL ORIGINAL) ---
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rutas para Gestión de Productos
    Route::get('/productos', [WebProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/vincular', [WebProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [WebProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [WebProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [WebProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [WebProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get('/productos/{producto}', [WebProductoController::class, 'show'])->name('productos.show');

    // Rutas de Clientes
    Route::get('/clientes', [WebClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/{cliente}', [WebClienteController::class, 'show'])->name('clientes.show');
    Route::patch('/clientes/{cliente}/toggle', [WebClienteController::class, 'toggle'])->name('clientes.toggle');
    Route::get('/clientes/{cliente}/edit', [WebClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{cliente}', [WebClienteController::class, 'update'])->name('clientes.update');
    
    // Gestión de Pedidos
    Route::get('/pedidos', [WebPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [WebPedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/estado', [WebPedidoController::class, 'updateStatus'])->name('pedidos.updateStatus');

    // CRUD de Usuarios Administrativos y Banners
    Route::resource('users', UserController::class);
    
    Route::get('/banners', [WebBannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/nuevo', [WebBannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [WebBannerController::class, 'store'])->name('banners.store');
    Route::delete('/banners/{banner}', [WebBannerController::class, 'destroy'])->name('banners.destroy');
    Route::get('/banners/{banner}/editar', [WebBannerController::class, 'edit'])->name('banners.edit');
    Route::post('/banners/{banner}', [WebBannerController::class, 'update'])->name('banners.update');
});

// --- TIENDA Y ÁREA DE CLIENTE (MEJORADO) ---
Route::name('store.')->group(function () {
    Route::get('/registro', [RegisterController::class, 'create'])->name('register.view');
    Route::post('/registro', [RegisterController::class, 'store'])->name('register.attempt');

    Route::middleware(['auth', 'role:cliente'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.view');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

        Route::prefix('mi-cuenta')->group(function () {
            Route::get('/perfil', [CustomerController::class, 'profile'])->name('profile');
            Route::get('/pedidos', [CustomerController::class, 'orders'])->name('orders');
            Route::get('/botiquin', [CustomerController::class, 'medicineCabinet'])->name('cabinet');
            Route::post('/direccion', [CustomerController::class, 'storeAddress'])->name('address.store');
        });
    });
});

require __DIR__.'/settings.php';