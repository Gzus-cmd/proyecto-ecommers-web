<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\Admin\WebProductoController;
use App\Http\Controllers\Admin\WebClienteController;
use App\Http\Controllers\Admin\WebPedidoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Admin\WebBannerController;

//Rutas publicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
// Detalle de Producto
Route::get('/producto/{producto:slug}', [App\Http\Controllers\Public\ProductController::class, 'show'])->name('product.show');


Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard general
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

// --- PANEL ADMINISTRATIVO (CRUD WEB) ---
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Rutas para Gestión de Productos
    Route::get('/productos', [WebProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/vincular', [WebProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [WebProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [WebProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [WebProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [WebProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get('/productos/{producto}', [WebProductoController::class, 'show'])->name('productos.show');

    // Rutas de Clientes (Solo lectura y actualización de estado)
    Route::get('/clientes', [WebClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/{cliente}', [WebClienteController::class, 'show'])->name('clientes.show');
    Route::patch('/clientes/{cliente}/toggle', [WebClienteController::class, 'toggle'])->name('clientes.toggle');
    Route::get('/clientes/{cliente}/edit', [WebClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{cliente}', [WebClienteController::class, 'update'])->name('clientes.update');
    
    // Gestión de Pedidos
    Route::get('/pedidos', [WebPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [WebPedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/estado', [WebPedidoController::class, 'updateStatus'])->name('pedidos.updateStatus');


    // CRUD de Usuarios Administrativos
    Route::resource('users', UserController::class);

    //Banner
    Route::get('/banners', [WebBannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/nuevo', [WebBannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [WebBannerController::class, 'store'])->name('banners.store');
    Route::delete('/banners/{banner}', [WebBannerController::class, 'destroy'])->name('banners.destroy');
    
    Route::get('/banners/{banner}/editar', [WebBannerController::class, 'edit'])->name('banners.edit');

    Route::post('/banners/{banner}', [WebBannerController::class, 'update'])->name('banners.update');


});

require __DIR__.'/settings.php';