<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Laboratoire;
use App\Models\Maintenance;
use App\Models\Notification;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $recent_reservations = Reservation::with(['user','laboratoire','equipements','horaires'])
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->take(5)
            ->get();

        $recent_maintenances = Maintenance::with(['equipement', 'user'])
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_laboratories' => Laboratoire::count(),
            'total_equipments' => Equipement::count(),
            'total_users' => User::count(),
            'total_reservations' => Reservation::count(),
            'active_maintenances' => Maintenance::count(),
        ];

        return view('admin.dashboard', compact('notifications', 'stats', 'recent_reservations', 'recent_maintenances'));
    }
}
