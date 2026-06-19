<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\WebProductoController;
use App\Http\Controllers\Admin\WebPedidoController;
use App\Http\Controllers\Admin\WebClienteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Tienda Pública (Home y Catálogo)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/*
|--------------------------------------------------------------------------
| Panel Administrativo (CRUD - Gestión de la Web)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard'); 
    })->name('dashboard');

    
    Route::resource('productos', WebProductoController::class);
    
    
    Route::resource('pedidos', WebPedidoController::class);

    
    Route::resource('clientes', WebClienteController::class);
});

/*
|--------------------------------------------------------------------------
| Perfil de Usuario (Común)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';