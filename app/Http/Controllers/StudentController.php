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
                'Renang gaya bebas (front crawl atau freestyle)', 'Renang gaya dada (breaststroke)', 'Renang gaya punggung (backstroke)', 'Renang gaya kupu-kupu (butterfly stroke)',
                'Gaya renang samping (sidestroke)', 'Gaya combat', 'Gaya renang bawah air', 'Gaya renang trudgen',
                'Gaya renang anjing (dog paddle style)', 'Gaya renang penyelamatan'
            ],
            'LEVEL 2' => [
                'Renang gaya bebas (front crawl atau freestyle)', 'Renang gaya dada (breaststroke)', 'Renang gaya punggung (backstroke)', 'Renang gaya kupu-kupu (butterfly stroke)',
                'Gaya renang samping (sidestroke)', 'Gaya combat', 'Gaya renang bawah air', 'Gaya renang trudgen',
                'Gaya renang anjing (dog paddle style)', 'Gaya renang penyelamatan'
            ],
            'LEVEL 3' => [
                'Renang gaya bebas (front crawl atau freestyle)', 'Renang gaya dada (breaststroke)', 'Renang gaya punggung (backstroke)', 'Renang gaya kupu-kupu (butterfly stroke)',
                'Gaya renang samping (sidestroke)', 'Gaya combat', 'Gaya renang bawah air', 'Gaya renang trudgen',
                'Gaya renang anjing (dog paddle style)', 'Gaya renang penyelamatan'
            ]
        ];

        // Determine student skills based on level
        $studentLevel = strtoupper(trim($student->level ?? 'LEVEL 1'));
        $studentSkills = $skills[$studentLevel] ?? $skills['LEVEL 1'];
        
        $savedSkills = isset($student->completed_skills) ? (array) $student->completed_skills : [];
        $completedSkills = [];
        foreach ($studentSkills as $skillName) {
            $completedSkills[$skillName] = in_array($skillName, $savedSkills);
        }

        $savedAttendance = isset($student->attendance) ? (array) $student->attendance : array_fill(0, 8, 'Belum');
        $attendance = [];
        for ($i = 0; $i < 8; $i++) {
            $attendance[] = [
                'meeting' => $i + 1,
                'status' => $savedAttendance[$i] ?? 'Belum'
            ];
        }

        // Payment status based on nominal
        $paymentStatus = !empty($student->nominal) && $student->nominal !== '-' ? 'Lunas' : 'Belum Bayar';

        return view('students.show', compact('student', 'completedSkills', 'attendance', 'paymentStatus'));
    }
    public function edit($id)
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

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:10',
            'location' => 'nullable|string|max:255',
            'program' => 'nullable|string|max:255',
            'schedule' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'nominal' => 'nullable|string|max:255',
        ]);

        $jsonPath = database_path('students_spreadsheet.json');
        
        if (!file_exists($jsonPath)) {
            return redirect()->route('students.index')->with('error', 'Data siswa tidak ditemukan.');
        }

        $raw = file_get_contents($jsonPath);
        $studentsData = json_decode($raw, true); // decode as associative array
        
        $updated = false;
        foreach ($studentsData as $key => $student) {
            if ($student['id'] == $id) {
                $studentsData[$key]['name'] = $request->name;
                $studentsData[$key]['parent_name'] = $request->parent_name;
                $studentsData[$key]['phone'] = $request->phone;
                $studentsData[$key]['age'] = $request->age;
                $studentsData[$key]['location'] = $request->location;
                $studentsData[$key]['program'] = $request->program;
                $studentsData[$key]['schedule'] = $request->schedule;
                $studentsData[$key]['level'] = $request->level;
                $studentsData[$key]['nominal'] = $request->nominal;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            file_put_contents($jsonPath, json_encode($studentsData, JSON_PRETTY_PRINT));
            return redirect()->route('students.show', $id)->with('success', 'Data siswa berhasil diperbarui!');
        }

        return redirect()->route('students.index')->with('error', 'Siswa tidak ditemukan.');
    }
    public function destroy($id)
    {
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus!');
    }

    public function updateEvaluation(Request $request, $id)
    {
        $jsonPath = database_path('students_spreadsheet.json');
        
        if (!file_exists($jsonPath)) {
            return redirect()->route('students.index')->with('error', 'Data siswa tidak ditemukan.');
        }

        $raw = file_get_contents($jsonPath);
        $studentsData = json_decode($raw, true);
        
        $updated = false;
        $skillsCompleted = $request->input('skills', []);
        $attendanceInput = $request->input('attendance', array_fill(0, 8, 'Belum'));
        
        foreach ($studentsData as $key => $student) {
            if ($student['id'] == $id) {
                $studentsData[$key]['completed_skills'] = $skillsCompleted;
                $studentsData[$key]['attendance'] = $attendanceInput;
                
                // Kalkulasi ulang progress berdasarkan bobot kesulitan per gaya renang
                $skillWeights = [
                    'Renang gaya bebas (front crawl atau freestyle)' => 15,
                    'Renang gaya dada (breaststroke)' => 15,
                    'Renang gaya punggung (backstroke)' => 15,
                    'Renang gaya kupu-kupu (butterfly stroke)' => 20,
                    'Gaya renang samping (sidestroke)' => 5,
                    'Gaya combat' => 5,
                    'Gaya renang bawah air' => 5,
                    'Gaya renang trudgen' => 5,
                    'Gaya renang anjing (dog paddle style)' => 5,
                    'Gaya renang penyelamatan' => 10,
                ];
                
                $newProgress = 0;
                foreach ($skillsCompleted as $skill) {
                    $newProgress += $skillWeights[$skill] ?? 0;
                }
                
                // Pastikan tidak lebih dari 100%
                $newProgress = min(100, $newProgress);
                $studentsData[$key]['progress'] = $newProgress;
                
                $updated = true;
                break;
            }
        }

        if ($updated) {
            file_put_contents($jsonPath, json_encode($studentsData, JSON_PRETTY_PRINT));
            return redirect()->route('students.show', $id)->with('success', 'Penilaian skill berhasil disimpan!');
        }

        return redirect()->route('students.index')->with('error', 'Siswa tidak ditemukan.');
    }
}
