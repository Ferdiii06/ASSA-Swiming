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
            $otherStudents = collect();
            
            if (file_exists($jsonPath)) {
                $allStudents = collect(json_decode(file_get_contents($jsonPath), true));
                
                // Find students matching this parent's phone or name (Strict match to prevent data leak)
                $parentStudents = $allStudents->filter(function ($student) use ($user) {
                    $matchPhone = !empty($user->phone) && !empty($student['phone']) && strcasecmp($student['phone'], $user->phone) === 0;
                    $matchName = !empty($user->name) && !empty($student['parent_name']) && strcasecmp($student['parent_name'], $user->name) === 0;
                    return $matchPhone || $matchName;
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

                // Prepare other active students for Leaderboard (Sanitized)
                $otherStudents = $allStudents->filter(function ($student) use ($user) {
                    $matchPhone = !empty($user->phone) && !empty($student['phone']) && strcasecmp($student['phone'], $user->phone) === 0;
                    $matchName = !empty($user->name) && !empty($student['parent_name']) && strcasecmp($student['parent_name'], $user->name) === 0;
                    
                    // Exclude parent's own students and only show Active
                    return !($matchPhone || $matchName) && (isset($student['status']) && $student['status'] === 'Active');
                })->map(function ($student) {
                    return (object)[
                        'name' => strtoupper($student['name'] ?? 'Anonim'),
                        'level' => $student['level'] ?? '-',
                        'program' => $student['program'] ?? '-',
                        'progress_percentage' => $student['progress'] ?? 0,
                        'coach_notes' => $student['coach_notes'] ?? '',
                        'schedule' => $student['schedule'] ?? '-',
                        'package_meetings' => $student['package_meetings'] ?? 8,
                    ];
                })->sortByDesc('progress_percentage')->values();
            }

            return view('dashboard', [
                'isParent' => true,
                'students' => $parentStudents,
                'otherStudents' => $otherStudents
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

        $coachesList = [];
        $parentsList = [];
        if ($user && (stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false)) {
            $coachesList = \App\Models\User::where('role', 'coach')->get();
            $parentsList = \App\Models\User::where('role', 'parent')->get();
        }

        return view('dashboard', [
            'isParent' => false,
            'totalStudents' => $totalStudents,
            'activeStudents' => $activeStudents,
            'totalPrograms' => $totalPrograms,
            'totalCoaches' => \App\Models\User::where('role', 'coach')->count(),
            'coachesList' => $coachesList,
            'parentsList' => $parentsList,
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

    public function storeCoach(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menambah Coach.');
        }

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'coach',
            'email_verified_at' => now(), // Auto verify for coaches
        ]);

        return back()->with('success', 'Akun Coach berhasil ditambahkan!');
    }

    public function updateCoach(Request $request, $id)
    {
        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit Coach.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
        ]);

        $coach = \App\Models\User::where('role', 'coach')->findOrFail($id);
        
        $coach->name = $request->name;
        $coach->email = $request->email;
        if ($request->filled('password')) {
            $coach->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $coach->save();

        return back()->with('success', 'Akun Coach berhasil diperbarui!');
    }

    public function destroyCoach($id)
    {
        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus Coach.');
        }

        $coach = \App\Models\User::where('role', 'coach')->findOrFail($id);
        
        // Prevent deleting themselves
        if ($coach->id === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $coach->delete();

        return back()->with('success', 'Akun Coach berhasil dihapus!');
    }

    public function updateParent(Request $request, $id)
    {
        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit Akun Orang Tua.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'nullable|string',
            'password' => 'nullable|min:6',
        ]);

        $parent = \App\Models\User::where('role', 'parent')->findOrFail($id);
        
        $parent->name = $request->name;
        $parent->email = $request->email;
        if ($request->filled('phone')) {
            $parent->phone = $request->phone;
        }
        if ($request->filled('password')) {
            $parent->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $parent->save();

        return back()->with('success', 'Akun Orang Tua berhasil diperbarui!');
    }

    public function destroyParent($id)
    {
        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus Akun Orang Tua.');
        }

        $parent = \App\Models\User::where('role', 'parent')->findOrFail($id);
        $parent->delete();

        return back()->with('success', 'Akun Orang Tua berhasil dihapus!');
    }

    public function bulkDestroyCoaches(Request $request)
    {
        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus Coach.');
        }

        $ids = $request->input('ids');
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'Tidak ada akun yang dipilih.');
        }

        // Filter out themselves
        $ids = array_filter($ids, function($id) use ($user) {
            return $id != $user->id;
        });

        if (count($ids) > 0) {
            \App\Models\User::where('role', 'coach')->whereIn('id', $ids)->delete();
        }

        return back()->with('success', count($ids) . ' Akun Coach berhasil dihapus!');
    }

    public function bulkDestroyParents(Request $request)
    {
        $user = auth()->user();
        $isAuthorized = stripos($user->name, 'Vicky') !== false || stripos($user->name, 'Arin') !== false;

        if (!$isAuthorized) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus Akun Orang Tua.');
        }

        $ids = $request->input('ids');
        if (empty($ids) || !is_array($ids)) {
            return back()->with('error', 'Tidak ada akun yang dipilih.');
        }

        \App\Models\User::where('role', 'parent')->whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' Akun Orang Tua berhasil dihapus!');
    }
}
