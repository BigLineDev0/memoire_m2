<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\Laboratoire;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $stats = [
            'total_users' => User::count(),
            'total_laboratories' => Laboratoire::count(),
            'total_equipments' => Equipement::count(),
            'total_reservations' => Reservation::count(),
        ];

        $laboratoires = Laboratoire::withCount('equipements')
            ->orderByDesc('equipements_count')
            ->take(3)
            ->get();
        return view('public.index', compact('stats', 'laboratoires'));
    }

    public function apropos()
    {
        return view('public.apropos');
    }

    public function laboratoires()
    {
        $laboratoires = Laboratoire::withCount('equipements')
            ->orderByDesc('equipements_count')
            ->paginate(6);

        return view('public.laboratoires', compact('laboratoires'));
    }

    public function contact()
    {
        return view('public.contact');
    }
}
