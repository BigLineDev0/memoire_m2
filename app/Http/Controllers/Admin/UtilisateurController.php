<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewAccountUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NouveauCompteMail;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = User::latest()->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        return view('admin.utilisateurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'role' => 'required|in:admin,chercheur,technicien',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Générer un mot de passe aléatoire
        $password = str()->random(10);

        // Enregistrer l’utilisateur
        $user = new User();
        $user->prenom = $request->prenom;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;
        $user->role = $request->role;
        $user->password = Hash::make($password);
        $user->status = 'active';

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('utilisateurs', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        // Envoi des identifiants par mail
        Mail::to($user->email)->send(new NewAccountUser($user, $password));

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur ajouté avec succès et identifiants envoyés par mail.');
    }

    public function edit(User $utilisateur)
    {
        return view('admin.utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, User $utilisateur)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $utilisateur->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'role' => 'required|in:admin,chercheur,technicien',
            'status' => 'required|in:active,suspendu',
            'photo' => 'nullable|image|max:2048',
        ]);

        $utilisateur->update([
            'prenom' => $request->prenom,
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('utilisateurs', 'public');
            $utilisateur->photo = $photoPath;
            $utilisateur->save();
        }

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $utilisateur)
    {
        $utilisateur->delete();
        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
