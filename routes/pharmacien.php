<?php

use App\Http\Controllers\Pharmacien\CommandeController;
use App\Http\Controllers\Pharmacien\DashboardController;
use App\Http\Controllers\Pharmacien\MedicamentController;
use App\Http\Controllers\Pharmacien\OrdonnanceController;
use App\Http\Controllers\Pharmacien\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:pharmacien,admin'])->prefix('pharmacien')->name('pharmacien.')->group(function () {
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Médicaments (CRUD + stocks)
    Route::get('/medicaments', [MedicamentController::class, 'index'])->name('medicaments.index');
    Route::get('/medicaments/nouveau', [MedicamentController::class, 'create'])->name('medicaments.create');
    Route::post('/medicaments', [MedicamentController::class, 'store'])->name('medicaments.store');
    Route::get('/medicaments/{medicament}/modifier', [MedicamentController::class, 'edit'])->name('medicaments.edit');
    Route::put('/medicaments/{medicament}', [MedicamentController::class, 'update'])->name('medicaments.update');
    Route::delete('/medicaments/{medicament}', [MedicamentController::class, 'destroy'])->name('medicaments.destroy');

    // Ordonnances
    Route::get('/ordonnances', [OrdonnanceController::class, 'index'])->name('ordonnances.index');
    Route::get('/ordonnances/{ordonnance}', [OrdonnanceController::class, 'show'])->name('ordonnances.show');
    Route::put('/ordonnances/{ordonnance}', [OrdonnanceController::class, 'valider'])->name('ordonnances.valider');

    // Commandes
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    Route::put('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.statut');

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});
