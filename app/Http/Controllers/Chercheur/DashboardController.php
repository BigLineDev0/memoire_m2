<?php

namespace App\Http\Controllers\Chercheur;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $stats = [
            'en_attente' => auth()->user()->reservations()->where('statut', 'en attente')->count(),
            'confirmees' => auth()->user()->reservations()->where('statut', 'confirme')->count(),
            'annulees' => auth()->user()->reservations()->where('statut', 'annule')->count(),
            'total_reservations' => auth()->user()->reservations()->count(),
        ];

        return view('chercheur.dashboard', compact('notifications', 'stats'));
    }
}
