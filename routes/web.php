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
require __DIR__.'/admin.php';
