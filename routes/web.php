<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Rutas para todos los usuarios
Route::get('/', function () {
    return view('welcome');
});

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/', [ArticuloController::class, 'ultimosArticulos']);
Route::get('/tiendas', [TiendaController::class, 'index'])->name('tiendas.index');
Route::get('/articulos/{articulo}', [ArticuloController::class, 'show'])->name('articulos.show');
Route::post('cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('add');
Route::get('cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::get('cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('clear');
Route::post('cart/removeitem', [App\Http\Controllers\CartController::class, 'removeItem'])->name('removeitem');
Route::post('/cart/update', [CartController::class, 'updateItem'])->name('updateitem');
Route::get('cart/payment', [App\Http\Controllers\CartController::class, 'payment'])->name('payment');
Route::post('/processPayment', [CartController::class, 'processPayment'])->name('processPayment');
Route::post('/consulta', [ConsultaController::class, 'store'])->name('consulta.store');


// Rutas solo para administradores excepto el metodo 'Show" de Articulos
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('/categorias', CategoriaController::class);
    Route::resource('/articulos', ArticuloController::class)->except(['show']);
    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::delete('/consultas/{consulta}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');
    Route::resource('users', UserController::class);


});

// Rutas para usuarios autenticados (incluyendo clientes)
Route::middleware(['auth'])->group(function () {
    // Agregar aquí las rutas accesibles tanto para clientes como para administradores
});

// Autenticación y otras rutas
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

