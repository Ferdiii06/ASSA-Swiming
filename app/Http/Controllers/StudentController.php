<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if (session('role', 'admin') === 'parent') {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Orang Tua (Parent) tidak diizinkan mengakses data manajemen siswa.');
        }

        $search = $request->get('search');
        $location = $request->get('location');
        $program = $request->get('program');
        $perPage = (int) $request->get('per_page', 15);
        $page = (int) $request->get('page', 1);

        $jsonPath = database_path('students_spreadsheet.json');
        
        if (file_exists($jsonPath)) {
            $raw = file_get_contents($jsonPath);
            $studentsData = collect(json_decode($raw));
        } else {
            $studentsData = collect([]);
        }

        // Apply Search Filter
        if ($search) {
            $studentsData = $studentsData->filter(function ($item) use ($search) {
                return stripos($item->name, $search) !== false 
                    || stripos($item->code, $search) !== false
                    || stripos($item->parent_name ?? '', $search) !== false
                    || stripos($item->address ?? '', $search) !== false;
            });
        }

        // Apply Location Filter
        if ($location) {
            $studentsData = $studentsData->filter(function ($item) use ($location) {
                return stripos($item->location ?? '', $location) !== false;
            });
        }

        // Apply Program Filter
        if ($program) {
            $studentsData = $studentsData->filter(function ($item) use ($program) {
                return strcasecmp($item->program ?? '', $program) === 0;
            });
        }

        $allStudents = file_exists($jsonPath) ? collect(json_decode(file_get_contents($jsonPath))) : collect([]);
        
        $totalStudents = $allStudents->count();
        $activeStudents = $allStudents->where('status', 'Active')->count();
        $avgProgress = $totalStudents > 0 ? round($allStudents->avg('progress')) : 0;
        $paidCount = $allStudents->filter(fn($s) => !empty($s->nominal))->count();

        // Get unique locations & programs for dropdown filters
        $locations = $allStudents->pluck('location')->filter()->unique()->values();
        $programs = $allStudents->pluck('program')->filter()->unique()->values();

        $stats = [
            'total_students' => $totalStudents,
            'active_students' => $activeStudents,
            'avg_progress' => $avgProgress,
            'paid_students' => $paidCount,
        ];

        // Paginate filtered results
        $filteredCollection = $studentsData->values();
        $totalFiltered = $filteredCollection->count();

        if ($perPage > 0) {
            $paginatedItems = $filteredCollection->slice(($page - 1) * $perPage, $perPage)->values();
            $paginatedStudents = new LengthAwarePaginator(
                $paginatedItems,
                $totalFiltered,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $paginatedStudents = new LengthAwarePaginator(
                $filteredCollection,
                $totalFiltered,
                $totalFiltered > 0 ? $totalFiltered : 1,
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view('students.index', [
            'students' => $paginatedStudents,
            'stats' => $stats,
            'search' => $search,
            'selectedLocation' => $location,
            'selectedProgram' => $program,
            'locations' => $locations,
            'programs' => $programs,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program' => 'required|string',
            'level' => 'required|string',
        ]);

        return redirect()->route('students.index')->with('success', 'Siswa baru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $jsonPath = database_path('students_spreadsheet.json');
        
        if (!file_exists($jsonPath)) {
            return redirect()->route('students.index')->with('error', 'Data siswa tidak ditemukan.');
        }

        $raw = file_get_contents($jsonPath);
        $studentsData = collect(json_decode($raw));
        
        $student = $studentsData->firstWhere('id', (int) $id);
        
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Siswa tidak ditemukan.');
        }

        // Mock data for Skills based on level
        $skills = [
            'LEVEL 1' => [
                'Adaptasi Air', 'Bubble', 'Floating', 'Streamline',
                'Kick', 'Meluncur', 'Freestyle', 'Backstroke',
                'Breaststroke', 'Butterfly', 'Diving', 'Survival', 'Water Safety'
            ],
            'LEVEL 2' => [
                'Adaptasi Air', 'Bubble', 'Floating', 'Streamline',
                'Kick', 'Meluncur', 'Freestyle', 'Backstroke',
                'Breaststroke', 'Butterfly', 'Diving', 'Survival', 'Water Safety'
            ],
            'LEVEL 3' => [
                'Adaptasi Air', 'Bubble', 'Floating', 'Streamline',
                'Kick', 'Meluncur', 'Freestyle', 'Backstroke',
                'Breaststroke', 'Butterfly', 'Diving', 'Survival', 'Water Safety'
            ]
        ];

        // Determine student skills based on level
        $studentLevel = strtoupper(trim($student->level ?? 'LEVEL 1'));
        $studentSkills = $skills[$studentLevel] ?? $skills['LEVEL 1'];
        
        // Mock Progress for skills (randomly check some based on progress percentage)
        $completedSkills = [];
        $totalSkills = count($studentSkills);
        $skillsToComplete = max(1, round(($student->progress ?? 0) / 100 * $totalSkills));
        for ($i = 0; $i < $totalSkills; $i++) {
            $completedSkills[$studentSkills[$i]] = $i < $skillsToComplete;
        }

        // Mock Attendance (8x pertemuan)
        // Let's generate a mockup attendance based on their progress
        $attendance = [];
        $totalMeetings = 8;
        $meetingsAttended = max(1, round(($student->progress ?? 0) / 100 * $totalMeetings));
        for ($i = 1; $i <= $totalMeetings; $i++) {
            if ($i <= $meetingsAttended) {
                $status = 'Hadir'; // Most likely hadir
                // Maybe 10% chance of alpha/izin if they haven't finished all
            } else {
                $status = 'Belum';
            }
            $attendance[] = [
                'meeting' => $i,
                'status' => $status
            ];
        }

        // Payment status based on nominal
        $paymentStatus = !empty($student->nominal) && $student->nominal !== '-' ? 'Lunas' : 'Belum Bayar';

        return view('students.show', compact('student', 'completedSkills', 'attendance', 'paymentStatus'));
    }

    public function destroy($id)
    {
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
