<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PharmacieController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Utilisateurs
    Route::get('/utilisateurs', [UserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/nouveau', [UserController::class, 'create'])->name('users.create');
    Route::post('/utilisateurs', [UserController::class, 'store'])->name('users.store');
    Route::get('/utilisateurs/{user}/modifier', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/utilisateurs/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/utilisateurs/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Pharmacies
    Route::get('/pharmacies', [PharmacieController::class, 'index'])->name('pharmacies.index');
    Route::get('/pharmacies/nouvelle', [PharmacieController::class, 'create'])->name('pharmacies.create');
    Route::post('/pharmacies', [PharmacieController::class, 'store'])->name('pharmacies.store');
    Route::get('/pharmacies/{pharmacie}/modifier', [PharmacieController::class, 'edit'])->name('pharmacies.edit');
    Route::put('/pharmacies/{pharmacie}', [PharmacieController::class, 'update'])->name('pharmacies.update');
    Route::delete('/pharmacies/{pharmacie}', [PharmacieController::class, 'destroy'])->name('pharmacies.destroy');
});
