<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessagerieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/a-propos', [PublicController::class, 'about'])->name('about');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/livraison', [PublicController::class, 'livraison'])->name('livraison');
Route::get('/pharmacies', [PublicController::class, 'pharmacies'])->name('pharmacies');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'contactEnvoyer'])->name('contact.envoyer');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/blog', [PublicController::class, 'blog'])->name('blog');

Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/catalogue/{medicament}', [CatalogueController::class, 'show'])->name('catalogue.show');

/*
|--------------------------------------------------------------------------
| Panier (accessible sans connexion)
|--------------------------------------------------------------------------
*/
Route::controller(PanierController::class)->prefix('panier')->name('panier.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/ajouter/{medicament}', 'ajouter')->name('ajouter');
    Route::patch('/modifier/{medicament}', 'modifier')->name('modifier');
    Route::delete('/supprimer/{medicament}', 'supprimer')->name('supprimer');
    Route::delete('/vider', 'vider')->name('vider');
});

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/inscription', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/inscription', [RegisteredUserController::class, 'store']);
    Route::get('/connexion', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/connexion', [AuthenticatedSessionController::class, 'store']);

    Route::get('/mot-de-passe-oublie', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [PasswordResetController::class, 'sendLink'])->name('password.email');
    Route::get('/reinitialiser-mot-de-passe/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reinitialiser-mot-de-passe', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/deconnexion', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Zone connectée
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

    // Notifications (tous rôles)
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{notification}/lire', 'lire')->name('lire');
        Route::post('/tout-lire', 'toutLire')->name('tout-lire');
    });

    // Messagerie (tous rôles)
    Route::controller(MessagerieController::class)->prefix('messagerie')->name('messagerie.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'show')->name('show');
        Route::post('/{user}', 'store')->name('store');
    });

    // Évaluation pharmacie
    Route::post('/pharmacies/{pharmacie}/avis', [AvisController::class, 'store'])->name('avis.store');
});

require __DIR__.'/patient.php';
require __DIR__.'/pharmacien.php';
require __DIR__.'/admin.php';
