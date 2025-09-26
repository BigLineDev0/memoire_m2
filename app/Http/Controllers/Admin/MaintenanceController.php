<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipement;
use App\Models\Maintenance;
use App\Models\Notification;
use App\Models\User;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with(['equipement', 'user'])
            ->latest()
            ->get();

        $equipements = Equipement::where('statut', 'maintenance')->get();
        $techniciens = User::where('role', 'technicien')->get();

        return view('admin.maintenances.index', compact('maintenances', 'equipements', 'techniciens'));
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
        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance planifiée avec succès.');

    }

    public function terminer(Request $request, Maintenance $maintenance)
    {
        if ($maintenance->statut !== 'en_cours') {
            return redirect()->route('admin.maintenances.index')
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
        $users = User::whereIn('role', ['admin', 'technicien'])->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'maintenance',
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance terminée avec succès et notifications envoyées.');
    }


    public function annuler(Maintenance $maintenance)
    {
        if ($maintenance->statut !== 'en_cours') {
            return redirect()->route('admin.maintenances.index')
                ->with('error', 'Seules les maintenances en cours peuvent être annulées.');
        }

        $maintenance->update(['statut' => 'annule']);
        $maintenance->equipement->update(['statut' => 'maintenance']);

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance annulée avec succès.');
    }

    public function destroy(Maintenance $maintenance)
    {
        // Vérification du rôle
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('admin.maintenances.index')
                ->with('error', 'Seul un administrateur peut supprimer une maintenance.');
        }

        // Si la maintenance était en cours → libérer l’équipement
        if ($maintenance->statut === 'en_cours') {
            $maintenance->equipement->update(['statut' => 'disponible']);
        }

        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Maintenance supprimée avec succès.');
    }

}
