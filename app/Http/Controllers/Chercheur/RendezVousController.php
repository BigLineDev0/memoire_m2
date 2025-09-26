<?php

namespace App\Http\Controllers\Chercheur;

use App\Http\Controllers\Controller;
use App\Mail\ReservationCancelled;
use App\Mail\ReservationConfirmed;
use App\Models\Horaire;
use App\Models\Laboratoire;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RendezVousController extends Controller
{
    public function index()
    {
        $laboratoires = Laboratoire::all();
        $reservations = Auth::user()->reservations()->with(['user','laboratoire','equipements','horaires'])->latest()->get();
        return view('chercheur.reservations.index', compact('reservations', 'laboratoires'));
    }

    public function create()
    {
        $laboratoires = Laboratoire::with('equipements')->get();
        $horaires = Horaire::all();
        return view('chercheur.reservations.create', compact('laboratoires','horaires'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'laboratoire_id' => 'required|exists:laboratoires,id',
            'date' => 'required|date|after_or_equal:today',
            'equipements' => 'required|array',
            'horaires' => 'required|array',
        ]);

        // 🔴 Vérification : aucun conflit d’équipements/horaires
        foreach ($request->equipements as $eqId) {
            $conflit = Reservation::where('laboratoire_id', $request->laboratoire_id)
                ->where('date', $request->date)
                ->whereHas('equipements', fn($q) => $q->where('equipement_id',$eqId))
                ->whereHas('horaires', fn($q) => $q->whereIn('horaire_id',$request->horaires))
                ->exists();
            if ($conflit) {
                return back()->withErrors(['equipements' => 'Un des équipements choisis est déjà réservé sur ce créneau !'])->withInput();
            }
        }

        $reservation = Reservation::create($request->only('user_id','laboratoire_id','date','objectif'));
        $reservation->equipements()->sync($request->equipements);
        $reservation->horaires()->sync($request->horaires);

        // Envoi du mail
        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        return redirect()->route('chercheur.reservations.index')->with('success', 'Réservation effectuée et email envoyé.');
    }

    public function edit(Reservation $reservation)
    {
        $laboratoires = Laboratoire::with('equipements')->get();
        $horaires = Horaire::all();
        return view('chercheur.reservations.edit', compact('reservation','laboratoires','horaires'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'laboratoire_id' => 'required|exists:laboratoires,id',
            'date' => 'required|date|after_or_equal:today',
            'equipements' => 'required|array',
            'horaires' => 'required|array',
        ]);

        $reservation->update($request->only('user_id', 'laboratoire_id','date','objectif'));
        $reservation->equipements()->sync($request->equipements);
        $reservation->horaires()->sync($request->horaires);

        return redirect()->route('chercheur.reservations.index')->with('success','Réservation mise à jour');
    }


    // 🔵 API pour les horaires disponibles
    public function horairesDisponibles(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'laboratoire_id' => 'required|exists:laboratoires,id',
        ]);

        $horaires = Horaire::all();

        $reservations = Reservation::where('laboratoire_id', $request->laboratoire_id)
            ->where('date', $request->date);

        // 👉 Exclure la réservation en cours si on est en édition
        if ($request->filled('reservation_id')) {
            $reservations->where('id', '!=', $request->reservation_id);
        }

        $horairesReserves = $reservations->with('horaires')
            ->get()
            ->pluck('horaires.*.id')
            ->flatten()
            ->toArray();

        return $horaires->map(fn($h) => [
            'id' => $h->id,
            'debut' => $h->debut,
            'fin' => $h->fin,
            'disponible' => !in_array($h->id, $horairesReserves),
        ]);
    }

    // 🔵 API pour équipements dispo
    public function equipementsDisponibles(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'laboratoire_id' => 'required|exists:laboratoires,id',
        ]);

        $labo = Laboratoire::with('equipements')->findOrFail($request->laboratoire_id);

        $reservations = Reservation::where('laboratoire_id', $request->laboratoire_id)
            ->where('date', $request->date);

        // 👉 Exclure la réservation en cours si édition
        if ($request->filled('reservation_id')) {
            $reservations->where('id', '!=', $request->reservation_id);
        }

        $equipementsReserves = $reservations->with('equipements')
            ->get()
            ->pluck('equipements.*.id')
            ->flatten()
            ->toArray();

        return $labo->equipements->map(fn($e) => [
            'id' => $e->id,
            'nom' => $e->nom,
            'disponible' => !in_array($e->id, $equipementsReserves),
        ]);
    }

    public function cancel(Reservation $reservation)
    {
        // Vérifier si la réservation est passée
        if ($reservation->date->isPast()) {
            return redirect()->back()->with('error', 'Cette réservation est déjà passée et ne peut pas être annulée.');
        }

        // Changer le statut
        $reservation->update(['statut' => 'annule']);

        // Envoyer un mail à l’utilisateur
        Mail::to($reservation->user->email)->send(new ReservationCancelled($reservation));

        return redirect()->back()->with('success', 'Réservation annulée et email envoyé.');
    }
}
