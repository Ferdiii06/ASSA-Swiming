<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->isParent()) {
            $students = $user->students()->with([
                'enrollments' => function($q) {
                    $q->active()->with('schedule.coach', 'program');
                },
                'progressReports' => function($q) {
                    $q->latest('created_at');
                },
                'payments' => function($q) {
                    $q->latest('created_at');
                }
            ])->get();

            return view('dashboard', [
                'isParent' => true,
                'students' => $students
            ]);
        }

        return view('dashboard', [
            'isParent' => false,
            'totalAcara' => 12,
            'totalSeri' => 34,
            'totalLomba' => 210,
            'totalClub' => 58,
            'upcomingAcara' => [],
            'topClubs' => [],
        ]);
    }

    public function switchRole($role)
    {
        if (in_array($role, ['admin', 'coach', 'parent'])) {
            session(['role' => $role]);
        }
        
        // Redirect to dashboard if parent tries to access restricted pages
        if ($role === 'parent' && request()->headers->get('referer') && str_contains(request()->headers->get('referer'), '/students')) {
            return redirect()->route('dashboard')->with('info', 'Akses dibatasi untuk role Parent.');
        }

        return redirect()->back();
    }
}
