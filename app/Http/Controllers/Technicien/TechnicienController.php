<?php

namespace App\Http\Controllers\Technicien;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Laboratoire;
use App\Models\Maintenance;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicienController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with(['equipement', 'user'])
            ->latest()
            ->get();

        $equipements = Equipement::where('statut', 'maintenance')->get();
        $techniciens = User::where('role', 'technicien')->get();

        return view('technicien.maintenances.index', compact('maintenances', 'equipements', 'techniciens'));
    }

    public function planifier(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'equipement_id' => 'required|exists:equipements,id',
            'date_prevue' => 'required|date',
        ]);

        $maintenance = Maintenance::create([
            'user_id' => $request->user_id,
            'equipement_id' => $request->equipement_id,
            'date_prevue' => $request->date_prevue,
            'statut' => 'en_cours',
        ]);

        $maintenance->equipement->update(['statut' => 'maintenance']);
        return redirect()->route('technicien.maintenances.index')->with('success', 'Maintenance planifiée avec succès.');

    }

    public function terminer(Request $request, Maintenance $maintenance)
    {
        if ($maintenance->statut !== 'en_cours') {
            return redirect()->route('technicien.maintenances.index')
                ->with('error', 'Seules les maintenances en cours peuvent être terminées.');
        }

        $request->validate([
            'description' => 'nullable|string',
        ]);

        // Mettre à jour la maintenance existante
        $maintenance->update([
            'description' => $request->description,
            'statut' => 'termine',
        ]);

        // Rendre l’équipement disponible
        $maintenance->equipement->update(['statut' => 'disponible']);

        // Création des notifications pour les admins + techniciens
        $message = "L’équipement {$maintenance->equipement->nom} est maintenant disponible.";

        // Récupérer tous les admins + techniciens
        $users = User::whereIn('role', ['admin', 'technicien', 'chercheur'])->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'maintenance',
                'message' => $message,
            ]);
        }

        return redirect()->route('technicien.maintenances.index')
            ->with('success', 'Maintenance terminée avec succès et notifications envoyées.');
    }


    public function annuler(Maintenance $maintenance)
    {
        if ($maintenance->statut !== 'en_cours') {
            return redirect()->route('technicien.maintenances.index')
                ->with('error', 'Seules les maintenances en cours peuvent être annulées.');
        }

        $maintenance->update(['statut' => 'annule']);
        $maintenance->equipement->update(['statut' => 'maintenance']);

        return redirect()->route('technicien.maintenances.index')
            ->with('success', 'Maintenance annulée avec succès.');
    }

    public function equipements(Request $request)
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

        return view('technicien.equipements.index', compact('equipements', 'laboratoires'));
    }

    public function alerterEquipement(Equipement $equipement)
    {
        // 1. Mettre à jour le statut de l’équipement
        $equipement->update(['statut' => 'maintenance']);

        // 2. Récupérer le chercheur connecté
        $technicien = Auth::user();

        // 3. Trouver les techniciens et les admins
        $chercheurs = User::where('role', 'chercheur')->get();
        $admins      = User::where('role', 'admin')->get();

        // 4. Créer une notification pour chaque technicien
        foreach ($chercheurs as $chercheur) {
            Notification::create([
                'user_id'  => $chercheur->id,
                'message'  => "L’équipement {$equipement->nom} a été signalé en maintenance par {$technicien->prenom} {$technicien->name}.",
                'type'     => 'maintenance',
                'is_read'  => false,
            ]);
        }

        // 4. Créer une notification pour chaque admin
        foreach ($admins as $admin) {
            Notification::create([
                'user_id'  => $admin->id,
                'message'  => "L’équipement {$equipement->nom} a été signalé en maintenance par {$technicien->prenom} {$technicien->name}.",
                'type'     => 'maintenance',
                'is_read'  => false,
            ]);
        }

        // 5. Retour vers le tableau de bord chercheur
        return redirect()->route('technicien.equipements.index')
            ->with('success', "Vous avez signalé l’équipement {$equipement->nom} pour une maintenance.");
    }
}
