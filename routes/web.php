<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EquipementController;
use App\Http\Controllers\Admin\LaboratoireController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ====================== ADMINISTRATEUR ========================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Laboratoires
    Route::resource('laboratoires', LaboratoireController::class)->except(['show']);

    // Equipements
    Route::resource('equipements', EquipementController::class)->except(['show']);
    Route::post('equipements/import', [EquipementController::class, 'import'])->name('equipements.import');
    Route::get('/equipements/{equipement}/alerter', [EquipementController::class, 'alerterEquipement'])->name('equipements.alert');

    // Réservations
    Route::resource('reservations', ReservationController::class)->except(['show']);
    Route::get('/horaires-disponibles', [ReservationController::class,'horairesDisponibles']);
    Route::get('/equipements-disponibles', [ReservationController::class,'equipementsDisponibles']);
    Route::put('/reservations/{reservation}/annuler', [ReservationController::class, 'cancel'])->name('reservations.cancel');


    // Utilisateurs
    Route::resource('utilisateurs', UtilisateurController::class)->except(['show']);

    // Maintenances
    Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');

});

// ====================== CHERCHEUR ===============================
Route::prefix('chercheur')->middleware(['auth', 'role:chercheur'])->name('chercheur.')->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Chercheur\DashboardController::class, 'index'])->name('dashboard');
});

// ====================== TECHNICIEN ==========================
Route::prefix('technicien')->middleware(['auth', 'role:technicien'])->name('technicien.')->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Technicien\DashboardController::class, 'index'])->name('dashboard');
});
