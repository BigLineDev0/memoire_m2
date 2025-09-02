<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Laboratoire;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
     public function index(Request $request)
    {
        $laboratoires = Laboratoire::all();

        // Récupération des équipements avec jointure labo
        $equipements = Equipement::with('laboratoires')
            ->whereIn('statut', ['maintenance'])
            ->when($request->filled('labo_id'), function($query) use ($request) {
                $query->whereHas('laboratoires', function($q) use ($request) {
                    $q->where('laboratoire_id', $request->labo_id);
                });
            })
            ->latest()
            ->get();

        return view('admin.maintenances.index', compact('equipements', 'laboratoires'));
    }
}
