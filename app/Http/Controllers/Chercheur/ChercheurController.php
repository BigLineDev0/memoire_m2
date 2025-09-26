<?php

namespace App\Http\Controllers\Chercheur;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Laboratoire;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChercheurController extends Controller
{
    public function index(Request $request)
    {
        $laboratoires = Laboratoire::all();

        // Récupération des équipements avec jointure labo
        $equipements = Equipement::with('laboratoires')
            ->whereIn('statut', ['disponible', 'reserve'])
            ->when($request->filled('labo_id'), function($query) use ($request) {
                $query->whereHas('laboratoires', function($q) use ($request) {
                    $q->where('laboratoire_id', $request->labo_id);
                });
            })
            ->latest()
            ->get();

        return view('chercheur.equipements.index', compact('equipements', 'laboratoires'));
    }

    public function alerterEquipement(Equipement $equipement)
    {
        // 1. Mettre à jour le statut de l’équipement
        $equipement->update(['statut' => 'maintenance']);

        // 2. Récupérer le chercheur connecté
        $chercheur = Auth::user();

        // 3. Trouver les techniciens et les admins
        $techniciens = User::where('role', 'technicien')->get();
        $admins      = User::where('role', 'admin')->get();

        // 4. Créer une notification pour chaque technicien
        foreach ($techniciens as $technicien) {
            Notification::create([
                'user_id'  => $technicien->id,
                'message'  => "L’équipement {$equipement->nom} a été signalé en maintenance par {$chercheur->prenom} {$chercheur->name}.",
                'type'     => 'maintenance',
                'is_read'  => false,
            ]);
        }

        // 4. Créer une notification pour chaque admin
        foreach ($admins as $admin) {
            Notification::create([
                'user_id'  => $admin->id,
                'message'  => "L’équipement {$equipement->nom} a été signalé en maintenance par {$chercheur->prenom} {$chercheur->name}.",
                'type'     => 'maintenance',
                'is_read'  => false,
            ]);
        }

        // 5. Retour vers le tableau de bord chercheur
        return redirect()->route('chercheur.equipements.index')
            ->with('success', "Vous avez signalé l’équipement {$equipement->nom} pour une maintenance.");
    }

}
