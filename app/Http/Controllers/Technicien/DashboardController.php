<?php

namespace App\Http\Controllers\Technicien;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $recent_maintenances = auth()->user()->maintenances()->with(['equipement', 'user'])
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'equipement_maintenances' => Equipement::where('statut', 'maintenance')->count(),
            'equipement_disponibles' => Equipement::where('statut', ['disponible', 'reserve'])->count(),
            'maintenance_terminees' => auth()->user()->maintenances()->where('statut', 'termine')->count(),
            'maintenance_en_cours' => auth()->user()->maintenances()->where('statut', 'en_cours')->count(),
            'total_maintenances' => auth()->user()->maintenances()->count(),
        ];

        return view('technicien.dashboard', compact('notifications', 'stats', 'recent_maintenances'));
    }
}
