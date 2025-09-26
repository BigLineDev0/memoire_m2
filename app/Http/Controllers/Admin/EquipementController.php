<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Laboratoire;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipementController extends Controller
{
    public function index(Request $request)
    {
        $laboratoires = Laboratoire::all();

        // Récupération des équipements avec jointure labo
        $equipements = Equipement::with('laboratoires')
            ->whereIn('statut', ['disponible', 'reserve']) // <-- filtre uniquement ces statuts
            ->when($request->filled('labo_id'), function($query) use ($request) {
                $query->whereHas('laboratoires', function($q) use ($request) {
                    $q->where('laboratoire_id', $request->labo_id);
                });
            })
            ->latest()
            ->get();

        return view('admin.equipements.index', compact('equipements', 'laboratoires'));
    }


    public function create()
    {
        $laboratoires = Laboratoire::all();
        return view('admin.equipements.create', compact('laboratoires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'statut' => 'required|in:disponible,reserve,maintenance',
            'laboratoires' => 'nullable|array',
        ]);

        // gérer le cas d’ajout multiple via ";"
        $noms = explode(';', $request->nom);

        foreach ($noms as $nom) {
            $equipement = Equipement::create([
                'nom' => trim($nom),
                'description' => $request->description,
                'statut' => $request->statut,
            ]);

            if ($request->has('laboratoires')) {
                $equipement->laboratoires()->attach($request->laboratoires);
            }
        }

        return redirect()->route('admin.equipements.index')->with('success', 'Équipement(s) ajouté(s) avec succès');
    }

    public function edit(Equipement $equipement)
    {
        $laboratoires = Laboratoire::all();
        return view('admin.equipements.edit', compact('equipement','laboratoires'));
    }

    public function update(Request $request, Equipement $equipement)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'statut' => 'required|in:disponible,reserve,maintenance',
            'laboratoires' => 'nullable|array',
        ]);

        $equipement->update($request->only('nom','description','statut'));
        $equipement->laboratoires()->sync($request->laboratoires);

        return redirect()->route('admin.equipements.index')->with('success', 'Équipement mis à jour avec succès');
    }

    public function destroy(Equipement $equipement)
    {
        $equipement->delete();
        return redirect()->route('admin.equipements.index')->with('success', 'Équipement supprimé avec succès');
    }

    public function alerterEquipement(Equipement $equipement)
    {
        // 1. Mettre à jour le statut
        $equipement->update(['statut' => 'maintenance']);

        // 2. Trouver les techniciens et l’admin
        $techniciens = User::where('role', 'technicien')->get();
        $admin       = Auth::user(); // celui qui fait l’action (admin connecté)

        // 3. Créer une notification pour chaque technicien
        foreach ($techniciens as $technicien) {
            Notification::create([
                'user_id'       => $technicien->id,
                'message'       => "L’équipement {$equipement->nom} a été signalé en maintenance par {$admin->prenom} {$admin->name}.",
                'type'          => 'maintenance',
                'is_read'       => false,
            ]);
        }

        // 4. Créer une notification pour l’admin
        Notification::create([
            'user_id'       => $admin->id,
            'message'       => "Vous avez signalé l’équipement {$equipement->nom} pour maintenance.",
            'type'          => 'maintenance',
            'is_read'       => false,
        ]);

        // 5. Retour avec message flash
        return redirect()->route('admin.equipements.index')
            ->with('success', "Équipement {$equipement->nom} signalé pour une maintenance.");
    }

    // Import CSV
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = fopen($request->file('file'), 'r');
        while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
            Equipement::create([
                'nom' => $data[0],
                'description' => $data[1] ?? null,
                'statut' => $data[2] ?? 'disponible',
            ]);
        }
        fclose($file);

        return redirect()->route('admin.equipements.index')->with('success', 'Importation terminée');
    }
}
