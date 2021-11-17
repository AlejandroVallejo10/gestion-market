<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('components.admin.dashboard');
})->middleware(['auth'])->name('admin');
