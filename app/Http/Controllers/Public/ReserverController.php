<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ReservationConfirmed;
use App\Models\Horaire;
use App\Models\Laboratoire;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReserverController extends Controller
{
    public function reserver(Laboratoire $laboratoire)
    {
        // Récupérer les équipements liés via la table pivot
        // $equipements = $laboratoire->equipements()->where('statut', 'disponible')->get();
        $horaires = Horaire::all();
        return view('public.reservation', compact('laboratoire', 'horaires'));
    }

    public function store(Request $request, Laboratoire $laboratoire)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'equipements' => 'required|array',
            'horaires' => 'required|array',
        ]);

        // 🔴 Vérification : aucun conflit
        foreach ($request->equipements as $eqId) {
            $conflit = Reservation::where('laboratoire_id', $laboratoire->id)
                ->where('date', $request->date)
                ->whereHas('equipements', fn($q) => $q->where('equipement_id',$eqId))
                ->whereHas('horaires', fn($q) => $q->whereIn('horaire_id',$request->horaires))
                ->exists();
            if ($conflit) {
                return back()->withErrors(['equipements' => 'Un des équipements choisis est déjà réservé sur ce créneau !'])->withInput();
            }
        }

        // 🔵 Création réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'laboratoire_id' => $laboratoire->id,
            'date' => $request->date,
            'objectif' => $request->objectif ?? null,
        ]);

        $reservation->equipements()->sync($request->equipements);
        $reservation->horaires()->sync($request->horaires);

        // Envoi mail confirmation
        Mail::to($reservation->user->email)->send(new ReservationConfirmed($reservation));

        // ✅ Passer les détails dans la session flash
        return back()->with('reservation_success', [
            'laboratoire' => $laboratoire->nom,
            'date' => $reservation->date,
            'equipements' => $reservation->equipements->pluck('nom')->toArray(),
            'horaires' => $reservation->horaires->map(fn($h) => $h->debut . ' - ' . $h->fin)->toArray(),
            'objectif' => $reservation->objectif,
        ]);
    }

    // 🔵 API horaires disponibles
    public function horairesDisponibles(Request $request, Laboratoire $laboratoire)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $horaires = Horaire::all();

        $reservations = Reservation::where('laboratoire_id', $laboratoire->id)
            ->where('date', $request->date);

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

    // 🔵 API équipements disponibles
    public function equipementsDisponibles(Request $request, Laboratoire $laboratoire)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $reservations = Reservation::where('laboratoire_id', $laboratoire->id)
            ->where('date', $request->date);

        $equipementsReserves = $reservations->with('equipements')
            ->get()
            ->pluck('equipements.*.id')
            ->flatten()
            ->toArray();

        return $laboratoire->equipements->map(fn($e) => [
            'id' => $e->id,
            'nom' => $e->nom,
            'disponible' => !in_array($e->id, $equipementsReserves),
        ]);
    }
}
