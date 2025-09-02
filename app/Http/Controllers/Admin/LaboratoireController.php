<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaboratoireRequest;
use App\Models\Laboratoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaboratoireController extends Controller
{
    public function index()
    {
        $laboratoires = Laboratoire::latest()->get();
        return view('admin.laboratoires.index', compact('laboratoires'));
    }

    public function create()
    {
        return view('admin.laboratoires.create');
    }

    public function store(LaboratoireRequest $request)
    {
        $data = $request->only(['nom', 'description', 'localisation']);
        $data['statut'] = 'actif';

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('laboratoires', 'public');
        }

        Laboratoire::create($data);

        return redirect()->route('admin.laboratoires.index')->with('success', 'Laboratoire ajouté avec succès.');
    }

    public function edit(Laboratoire $laboratoire)
    {
        return view('admin.laboratoires.edit', compact('laboratoire'));
    }

    public function update(LaboratoireRequest $request, Laboratoire $laboratoire)
    {
        $data = $request->only(['nom', 'description', 'localisation']);
        
        // statut : checkbox => si pas coché => inactif
        $data['statut'] = $request->has('statut') ? 'actif' : 'inactif';

        if ($request->hasFile('photo')) {
            if ($laboratoire->photo) {
                Storage::disk('public')->delete($laboratoire->photo);
            }
            $data['photo'] = $request->file('photo')->store('laboratoires', 'public');
        }

        $laboratoire->update($data);

        return redirect()->route('admin.laboratoires.index')->with('success', 'Laboratoire mis à jour avec succès.');
    }


    public function destroy(Laboratoire $laboratoire)
    {
        if ($laboratoire->photo) {
            Storage::disk('public')->delete($laboratoire->photo);
        }

        $laboratoire->delete();

        return redirect()->route('admin.laboratoires.index')->with('success', 'Laboratoire supprimé avec succès.');
    }
}
