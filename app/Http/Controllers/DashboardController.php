<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalAcara' => 12,
            'totalSeri' => 34,
            'totalLomba' => 210,
            'totalClub' => 58,
            'upcomingAcara' => [],
            'topClubs' => [],
        ]);
    }
}
