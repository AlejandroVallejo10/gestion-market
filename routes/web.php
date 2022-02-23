<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::user()->rol == 1) {
        return redirect()->route('comprar');
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin', function () {
    if (Auth::user()->rol == 1) {
        return redirect()->route('comprar');
    }
    return view('components.admin.dashboard');
})->middleware(['auth'])->name('admin');

Route::get('/stores', function () {
        if (Auth::user()->rol == 1) {
        return redirect()->route('comprar');
    }
    return view('components.admin.stores');
})->middleware(['auth'])->name('stores');

Route::get('/warehouses', function () {
        if (Auth::user()->rol == 1) {
        return redirect()->route('comprar');
    }
    return view('components.admin.warehouses');
})->middleware(['auth'])->name('warehouses');

Route::get('/productos', function () {
        if (Auth::user()->rol == 1) {
        return redirect()->route('comprar');
    }
    return view('products');
})->middleware(['auth'])->name('productos');

Route::get('/reportes', function () {
        if (Auth::user()->rol == 1) {
        return redirect()->route('comprar');
    }
    return view('reports');
})->middleware(['auth'])->name('reportes');

Route::get('/comprar', function () {
    return view('comprar');
})->middleware(['auth'])->name('comprar');

Route::get('/transactions', function () {
    if (Auth::user()->rol == 1) {
    return redirect()->route('comprar');
}
return view('components.admin.transactions');
})->middleware(['auth'])->name('transactions');

Route::get('/transactionDetails', function () {
    if (Auth::user()->rol == 1) {
    return redirect()->route('comprar');
}
return view('components.admin.transactionDetails');
})->middleware(['auth'])->name('transactionDetails');

Route::get('/platform', function () {
    return view('components.admin.platform');
})->middleware(['auth'])->name('platform');


require __DIR__.'/auth.php';
