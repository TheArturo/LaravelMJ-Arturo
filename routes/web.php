<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Rutas de módulos para pruebas de sidebar
    Route::view('ventas/create', 'modulos.ventas.index')->name('ventas.create');
    Route::resource('clientes', \Src\Cliente\Controllers\ClienteController::class);
    Route::view('ventas', 'modulos.ventas.index')->name('ventas.index');
    Route::view('usuarios', 'modulos.usuarios.index')->name('usuarios.index');
    Route::view('productos', 'modulos.productos.index')->name('productos.index');
    Route::resource('proveedores', \Src\Proveedor\Controllers\ProveedorController::class);
    Route::get('proveedores/search', [\Src\Proveedor\Controllers\ProveedorController::class, 'search'])->name('proveedores.search');
    Route::view('configuracion', 'modulos.configuracion.index')->name('configuracion.index');
});

require __DIR__.'/auth.php';
