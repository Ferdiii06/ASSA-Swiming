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

        // Get data from JSON
        $jsonPath = database_path('students_spreadsheet.json');
        $students = [];
        $totalStudents = 0;
        $activeStudents = 0;
        $programs = [];
        
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $students = json_decode($json, true);
            
            if (is_array($students)) {
                $totalStudents = count($students);
                foreach ($students as $student) {
                    if (isset($student['status']) && $student['status'] === 'Active') {
                        $activeStudents++;
                    } elseif (isset($student['nominal']) && !empty($student['nominal'])) {
                        $activeStudents++;
                    }
                    
                    if (isset($student['program']) && !empty($student['program'])) {
                        $programs[$student['program']] = true;
                    }
                }
            }
        }
        
        $totalPrograms = count(array_keys($programs));

        return view('dashboard', [
            'isParent' => false,
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'totalPrograms' => $totalPrograms,
            'totalCoaches' => 4, // Vicky, Arin, Tiwi, Tasya
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
