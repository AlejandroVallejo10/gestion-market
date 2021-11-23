<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    return view('components.admin.dashboard');
})->middleware(['auth'])->name('admin');

Route::get('/stores', function () {
    return view('components.admin.stores');
})->middleware(['auth'])->name('stores');

Route::get('/warehouses', function () {
    return view('components.admin.warehouses');
})->middleware(['auth'])->name('warehouses');

Route::get('/productos', function () {
    return view('products');
})->middleware(['auth'])->name('productos');

Route::get('/reportes', function () {
    return view('reports');
})->middleware(['auth'])->name('reportes');

Route::get('/comprar', function () {
    return view('comprar');
})->middleware(['auth'])->name('comprar');


require __DIR__.'/auth.php';
