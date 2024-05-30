<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PornstarController;

Route::get('/', [PornstarController::class, 'index'])->name('pornstar.index');
Route::get('/pornstars/{id}', [PornstarController::class, 'show'])->name('pornstar.show');
Route::get('/api/pornstars/search', [PornstarController::class, 'search'])->name('pornstar.search');




require __DIR__.'/auth.php';
