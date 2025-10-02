<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Maintenance;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminRapportController extends Controller
{
    public function genererRapport()
    {
        // Récupérer les données
        $reservations = Reservation::with(['user','laboratoire','equipements','horaires'])->latest()->get();
        $maintenances = Maintenance::with(['equipement','user'])->latest()->get();

        // Charger la vue rapport
        $pdf = Pdf::loadView('admin.rapport', compact('reservations', 'maintenances'));

        // Télécharger le fichier
        return $pdf->download('rapport_systeme.pdf');
    }
}
