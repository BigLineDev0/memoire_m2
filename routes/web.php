<?php

use App\Http\Controllers\Admin\AdminRapportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\EquipementController;
use App\Http\Controllers\Admin\HoraireController;
use App\Http\Controllers\Admin\LaboratoireController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\UtilisateurController;

use App\Http\Controllers\Chercheur\DashboardController as ChercheurDashboard;
use App\Http\Controllers\Chercheur\ChercheurController;
use App\Http\Controllers\Chercheur\RendezVousController;

use App\Http\Controllers\Technicien\DashboardController as TechnicienDashboard;
use App\Http\Controllers\Technicien\TechnicienController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ReserverController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/a-propos', [HomeController::class, 'apropos'])->name('about');
Route::get('/laboratoires', [HomeController::class, 'laboratoires'])->name('laboratoires');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/unauthorized', fn () => view('unauthorized'))->name('unauthorized');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Routes authentifiées communes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirection dashboard selon rôle
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        return match ($role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'chercheur'  => redirect()->route('chercheur.dashboard'),
            'technicien' => redirect()->route('technicien.dashboard'),
            default      => abort(403, 'Rôle non autorisé.')
        };
    })->name('dashboard');

    // Réservations accessibles aux utilisateurs connectés
    Route::get('/reservations/{laboratoire}/create', [ReserverController::class, 'reserver'])->name('reservations.create');
    Route::post('/reservations/{laboratoire}', [ReserverController::class, 'store'])->name('reservations.store');

    Route::get('/reservations/{laboratoire}/horaires-disponibles', [ReserverController::class, 'horairesDisponibles'])->name('reservations.horaires');
    Route::get('/reservations/{laboratoire}/equipements-disponibles', [ReserverController::class, 'equipementsDisponibles'])->name('reservations.equipements');

});

/*
|--------------------------------------------------------------------------
| ADMINISTRATEUR
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Laboratoires
    Route::resource('laboratoires', LaboratoireController::class)->except(['show']);

    // Équipements
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

    // Horaires
    Route::resource('horaires', HoraireController::class)->except(['show']);

    // Rapports
    Route::get('/rapport', [AdminRapportController::class, 'genererRapport'])->name('rapport');


    // Maintenances
    Route::resource('maintenances', MaintenanceController::class)->except(['create', 'edit', 'show']);
    Route::post('maintenances/planifier', [MaintenanceController::class, 'planifier'])->name('maintenances.planifier');
    Route::post('maintenances/{maintenance}/terminer', [MaintenanceController::class, 'terminer'])->name('maintenances.terminer');
    Route::post('maintenances/{maintenance}/annuler', [MaintenanceController::class, 'annuler'])->name('maintenances.annuler');
});

/*
|--------------------------------------------------------------------------
| CHERCHEUR
|--------------------------------------------------------------------------
*/
Route::prefix('chercheur')->middleware(['auth', 'role:chercheur'])->name('chercheur.')->group(function () {
    Route::get('/dashboard', [ChercheurDashboard::class, 'index'])->name('dashboard');

    // Réservations
    Route::resource('reservations', RendezVousController::class)->except(['show']);
    Route::get('/horaires-disponibles', [RendezVousController::class,'horairesDisponibles']);
    Route::get('/equipements-disponibles', [RendezVousController::class,'equipementsDisponibles']);
    Route::put('/reservations/{reservation}/annuler', [RendezVousController::class, 'cancel'])->name('reservations.cancel');

    // Équipements
    Route::get('/equipements', [ChercheurController::class, 'index'])->name('equipements.index');
    Route::get('/equipements/{equipement}/alerter', [ChercheurController::class, 'alerterEquipement'])->name('equipements.alert');
});

/*
|--------------------------------------------------------------------------
| TECHNICIEN
|--------------------------------------------------------------------------
*/
Route::prefix('technicien')->middleware(['auth', 'role:technicien'])->name('technicien.')->group(function () {
    Route::get('/dashboard', [TechnicienDashboard::class, 'index'])->name('dashboard');

    // Maintenances
    Route::resource('maintenances', TechnicienController::class)->except(['create', 'edit', 'show', 'destroy']);
    Route::post('maintenances/planifier', [TechnicienController::class, 'planifier'])->name('maintenances.planifier');
    Route::post('maintenances/{maintenance}/terminer', [TechnicienController::class, 'terminer'])->name('maintenances.terminer');
    Route::post('maintenances/{maintenance}/annuler', [TechnicienController::class, 'annuler'])->name('maintenances.annuler');

    // Équipements
    Route::get('/equipements', [TechnicienController::class, 'equipements'])->name('equipements.index');
    Route::get('/equipements/{equipement}/alerter', [TechnicienController::class, 'alerterEquipement'])->name('equipements.alert');
});
