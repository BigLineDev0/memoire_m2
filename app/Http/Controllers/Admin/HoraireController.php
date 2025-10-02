<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horaire;
use Illuminate\Http\Request;

class HoraireController extends Controller
{
    public function index()
    {
        $horaires = Horaire::latest()->get();
        return view('admin.horaires.index', compact('horaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'debut' => 'required|date_format:H:i',
            'fin'   => 'required|date_format:H:i|after:debut',
        ]);

        Horaire::create($request->only('debut', 'fin'));

        return redirect()->route('admin.horaires.index')
                         ->with('success', 'Crenaux horaire créé avec succès.');
    }

    public function update(Request $request, Horaire $horaire)
    {
        $request->validate([
            'debut' => 'required|date_format:H:i',
            'fin'   => 'required|date_format:H:i|after:debut',
        ]);

        $horaire->update($request->only('debut', 'fin'));

        return redirect()->route('admin.horaires.index')
                         ->with('success', 'Crenaux horaire mis à jour avec succès.');
    }

    public function destroy(Horaire $horaire)
    {
        $horaire->delete();

        return redirect()->route('admin.horaires.index')
                         ->with('success', 'Crenaux horaire supprimé avec succès.');
    }
}
