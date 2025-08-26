<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Configuración
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Ventas
    Route::view('ventas', 'modulos.ventas.index')->name('ventas.index');
    Route::view('ventas/create', 'modulos.ventas.index')->name('ventas.create');

    // Clientes
    Route::resource('clientes', \Src\Cliente\Controllers\ClienteController::class);

    // Proveedores
    Route::resource('proveedores', \Src\Proveedor\Controllers\ProveedorController::class);
    Route::get('proveedores/search', [\Src\Proveedor\Controllers\ProveedorController::class, 'search'])->name('proveedores.search');

    // Productos
    Route::resource('productos', \Src\Producto\Controllers\ProductoController::class);

    // Categorías
    Route::resource('categorias', \Src\Categoria\Controllers\CategoriaController::class);

    // Usuarios
    Route::view('usuarios', 'modulos.usuarios.index')->name('usuarios.index');

    // Configuración
    Route::view('configuracion', 'modulos.configuracion.index')->name('configuracion.index');
});

require __DIR__ . '/auth.php';
