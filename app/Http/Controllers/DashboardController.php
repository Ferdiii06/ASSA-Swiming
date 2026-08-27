<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->isParent()) {
            $jsonPath = database_path('students_spreadsheet.json');
            $parentStudents = collect();
            
            if (file_exists($jsonPath)) {
                $allStudents = collect(json_decode(file_get_contents($jsonPath), true));
                // Find students matching this parent's phone or name
                $parentStudents = $allStudents->filter(function ($student) use ($user) {
                    return strcasecmp($student['phone'] ?? '', $user->phone) === 0 || 
                           strcasecmp($student['parent_name'] ?? '', $user->name) === 0;
                })->map(function ($student) {
                    // Cast to object and provide dummy relations to prevent view crash
                    $obj = (object) $student;
                    $obj->is_active = (isset($student['status']) && $student['status'] === 'Active');
                    $obj->progressReports = collect();
                    $obj->enrollments = collect();
                    $obj->payments = collect();
                    
                    // Add dummy enrollment based on JSON
                    if (isset($student['schedule']) && $student['schedule'] !== '-') {
                        $obj->enrollments->push((object)[
                            'schedule' => (object)[
                                'day_name' => explode(' ', $student['schedule'])[0],
                                'start_time' => \Carbon\Carbon::parse('00:00'),
                                'end_time' => \Carbon\Carbon::parse('00:00'),
                                'coach' => (object)['name' => '-']
                            ]
                        ]);
                    }
                    
                    // Add dummy progress report based on JSON
                    if (isset($student['progress'])) {
                        $obj->progressReports->push((object)[
                            'level' => $student['level'] ?? '-',
                            'skills_achieved' => '-',
                            'instructor_notes' => 'Lihat detail di laporan.',
                            'progress_percentage' => $student['progress'],
                            'attendance' => 0,
                            'total_sessions' => 8
                        ]);
                    }
                    
                    return $obj;
                })->values();
            }

            return view('dashboard', [
                'isParent' => true,
                'students' => $parentStudents
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
