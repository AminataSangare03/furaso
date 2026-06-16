<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\Patient\CommandeController as PatientCommandeController;
use App\Http\Controllers\Patient\DashboardController;
use App\Http\Controllers\Patient\FavoriController;
use App\Http\Controllers\Patient\OrdonnanceController;
use App\Http\Controllers\Patient\ProfilController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/mot-de-passe', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // Ordonnances
    Route::get('/ordonnances', [OrdonnanceController::class, 'index'])->name('ordonnances.index');
    Route::get('/ordonnances/nouvelle', [OrdonnanceController::class, 'create'])->name('ordonnances.create');
    Route::post('/ordonnances', [OrdonnanceController::class, 'store'])->name('ordonnances.store');
    Route::get('/ordonnances/{ordonnance}', [OrdonnanceController::class, 'show'])->name('ordonnances.show');

    // Commandes
    Route::get('/commandes', [PatientCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [PatientCommandeController::class, 'show'])->name('commandes.show');

    // Checkout
    Route::get('/commander', [CommandeController::class, 'checkout'])->name('checkout');
    Route::post('/commander', [CommandeController::class, 'store'])->name('checkout.store');

    // Favoris
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{medicament}', [FavoriController::class, 'toggle'])->name('favoris.toggle');
});
