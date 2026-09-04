<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // ... (rest of index method is unchanged)
        if (auth()->check() && auth()->user()->isParent()) {
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
        $dbPrograms = Program::all();
        $locations = $allStudents->pluck('location')->merge($dbPrograms->pluck('pool_name'))->filter()->unique()->values();
        $programs = $allStudents->pluck('program')->merge($dbPrograms->pluck('name'))->filter()->unique()->values();

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
        $dbPrograms = Program::all();
        return view('students.create', compact('dbPrograms'));
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

    public function show(Request $request, $id)
    {
        $selectedMonth = $request->get('month', date('Y-m'));
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

        $user = auth()->user();
        if ($user && $user->isParent()) {
            $isOwner = strcasecmp($student->phone ?? '', $user->phone) === 0 || 
                       strcasecmp($student->parent_name ?? '', $user->name) === 0;
            
            if (!$isOwner) {
                return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Anda tidak memiliki akses ke data siswa ini.');
            }
        }

        $skills = [
            'LEVEL 1' => [
                'Adaptasi air' => 'Siswa mampu beradaptasi dengan suhu dan lingkungan air tanpa rasa panik.',
                'Pernafasan dasar' => 'Siswa dapat menahan napas dan membuang napas di dalam air (bubbling).',
                'Berani masuk kolam' => 'Siswa dapat turun ke dalam kolam secara mandiri dan percaya diri.'
            ],
            'LEVEL 2' => [
                'Mengapung telentang & tengkurap' => 'Kemampuan menjaga keseimbangan tubuh di permukaan air tanpa bantuan.',
                'Streamline' => 'Mampu meluncur dengan posisi tubuh lurus membelah air (tangan di depan).',
                'Meluncur' => 'Daya dorong awal dari dinding kolam dengan postur tubuh yang benar.'
            ],
            'LEVEL 3' => [
                'Freestyle Kick' => 'Gerakan tendangan kaki gaya bebas yang konstan dan propulsif dari pangkal paha.',
                'Backstroke Kick' => 'Gerakan tendangan kaki gaya punggung secara stabil di permukaan air.',
                'Breaststroke Kick' => 'Tendangan katak (gaya dada) dengan bukaan dan dorongan kaki yang tepat.',
                'Dolphin Kick' => 'Gerakan meliuk layaknya lumba-lumba untuk awalan dan gaya kupu-kupu.'
            ],
            'LEVEL 4' => [
                'Gerakan tangan' => 'Ayunan tangan (pull & recovery) pada gaya bebas secara benar.',
                'Side breathing' => 'Pengambilan napas dari arah samping (kiri/kanan) seirama dengan ayunan tangan.',
                'Koordinasi gaya bebas' => 'Penyatuan gerakan kaki, tangan, dan pernapasan untuk berenang gaya bebas secara utuh.'
            ],
            'LEVEL 5' => [
                'Teknik gaya punggung' => 'Posisi wajah di atas air dengan ayunan tangan berputar ke belakang secara bergantian.',
                'Koordinasi penuh' => 'Integrasi antara tendangan kaki dan ayunan tangan pada gaya punggung tanpa tenggelam.'
            ],
            'LEVEL 6' => [
                'Breaststroke Kick' => 'Penyempurnaan kekuatan dorongan kaki katak agar laju lebih cepat.',
                'Pull & Glide' => 'Sinkronisasi tarikan tangan di bawah air dan momen meluncur (glide) pada gaya dada.',
                'Koordinasi penuh' => 'Menyelaraskan tarikan tangan, tendangan, dan pernapasan secara ritmis.'
            ],
            'LEVEL 7' => [
                'Dolphin Body Motion' => 'Meliukkan seluruh tubuh dari dada hingga ujung kaki secara ritmis.',
                'Butterfly Arm Recovery' => 'Lemparan kedua belah lengan secara bersamaan ke depan.',
                'Koordinasi gaya kupu-kupu' => 'Integrasi gerakan tubuh lumba-lumba, lemparan lengan, dan pernapasan secara simultan.'
            ],
            'LEVEL 8' => [
                'Penyempurnaan 4 gaya' => 'Koreksi akhir teknik Gaya Bebas, Dada, Punggung, dan Kupu-Kupu.',
                'Endurance' => 'Latihan daya tahan berenang dalam jarak menengah tanpa kelelahan berlebih.',
                'Speed Training' => 'Latihan interval untuk meningkatkan kecepatan berenang.'
            ],
            'LEVEL 9' => [
                'Start' => 'Teknik lompatan awal (diving) dari pinggir kolam / starting block.',
                'Turn' => 'Teknik berbalik (flip turn / open turn) di ujung kolam tanpa kehilangan momentum.',
                'Finish' => 'Teknik menyentuh dinding kolam dengan benar di akhir lintasan.',
                'Race Technique' => 'Pemahaman strategi balapan dan pacing (pengaturan kecepatan).'
            ],
            'LEVEL 10' => [
                'Program atlet' => 'Latihan terstruktur layaknya atlet profesional (volume & intensitas tinggi).',
                'Target lomba' => 'Persiapan mental dan fisik menuju kompetisi nyata.',
                'Performance training' => 'Optimalisasi teknik mikrosekon dan analisis performa secara detail.'
            ]
        ];

        // Determine student skills based on level
        $studentLevel = strtoupper(trim($student->level ?? 'LEVEL 1'));
        $studentSkills = $skills[$studentLevel] ?? $skills['LEVEL 1'];

        $savedSkills = isset($student->completed_skills) ? (array) $student->completed_skills : [];
        $completedSkills = [];
        foreach ($studentSkills as $skillName => $skillDesc) {
            $completedSkills[$skillName] = [
                'is_completed' => in_array($skillName, $savedSkills),
                'description'  => $skillDesc
            ];
        }

        $package_meetings = isset($student->package_meetings) ? (int) $student->package_meetings : 8;
        
        // Fetch attendance for selected month
        $attendanceHistory = isset($student->attendance_history) ? (array) $student->attendance_history : [];
        if (isset($attendanceHistory[$selectedMonth])) {
            $savedAttendance = (array) $attendanceHistory[$selectedMonth];
        } else {
            // Fallback for old data or new month
            $savedAttendance = isset($student->attendance) && count($attendanceHistory) === 0 ? (array) $student->attendance : array_fill(0, $package_meetings, 'Belum');
        }
        
        $attendance = [];
        for ($i = 0; $i < $package_meetings; $i++) {
            $attendance[] = [
                'meeting' => $i + 1,
                'status' => $savedAttendance[$i] ?? 'Belum'
            ];
        }

        $holidaysHistory = isset($student->holidays_history) ? (array) $student->holidays_history : [];
        if (isset($holidaysHistory[$selectedMonth])) {
            $holidays = (array) $holidaysHistory[$selectedMonth];
        } else {
            // Fallback for old data or new month
            $holidays = isset($student->holidays) && count($holidaysHistory) === 0 ? (array) $student->holidays : [];
        }

        // Payment status based on nominal
        $paymentStatus = !empty($student->nominal) && $student->nominal !== '-' ? 'Lunas' : 'Belum Bayar';

        return view('students.show', compact('student', 'completedSkills', 'attendance', 'paymentStatus', 'holidays', 'package_meetings', 'selectedMonth'));
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

        $dbPrograms = Program::all();
        return view('students.edit', compact('student', 'dbPrograms'));
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
            'package_meetings' => 'nullable|integer',
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
                $studentsData[$key]['package_meetings'] = (int) $request->package_meetings;
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

        foreach ($studentsData as $key => $student) {
            if ($student['id'] == $id) {
                $package_meetings = isset($student['package_meetings']) ? (int) $student['package_meetings'] : 8;
                $attendanceInput = $request->input('attendance', array_fill(0, $package_meetings, 'Belum'));
                $holidaysInput = $request->input('holidays', []);
                $monthInput = $request->input('month', date('Y-m'));

                $studentsData[$key]['completed_skills'] = $skillsCompleted;

                // Save to history
                if (!isset($studentsData[$key]['attendance_history'])) {
                    $studentsData[$key]['attendance_history'] = [];
                }
                if (!isset($studentsData[$key]['holidays_history'])) {
                    $studentsData[$key]['holidays_history'] = [];
                }

                $studentsData[$key]['attendance_history'][$monthInput] = $attendanceInput;
                $studentsData[$key]['holidays_history'][$monthInput] = array_filter($holidaysInput);
                
                // Keep the root updated as fallback
                $studentsData[$key]['attendance'] = $attendanceInput;
                $studentsData[$key]['holidays'] = array_filter($holidaysInput);

                // Kalkulasi ulang progress berdasarkan jumlah skill yang dikuasai
                $skillsMap = [
                    'LEVEL 1' => ['Adaptasi air', 'Pernafasan dasar', 'Berani masuk kolam'],
                    'LEVEL 2' => ['Mengapung telentang & tengkurap', 'Streamline', 'Meluncur'],
                    'LEVEL 3' => ['Freestyle Kick', 'Backstroke Kick', 'Breaststroke Kick', 'Dolphin Kick'],
                    'LEVEL 4' => ['Gerakan tangan', 'Side breathing', 'Koordinasi gaya bebas'],
                    'LEVEL 5' => ['Teknik gaya punggung', 'Koordinasi penuh'],
                    'LEVEL 6' => ['Breaststroke Kick', 'Pull & Glide', 'Koordinasi penuh'],
                    'LEVEL 7' => ['Dolphin Body Motion', 'Butterfly Arm Recovery', 'Koordinasi gaya kupu-kupu'],
                    'LEVEL 8' => ['Penyempurnaan 4 gaya', 'Endurance', 'Speed Training'],
                    'LEVEL 9' => ['Start', 'Turn', 'Finish', 'Race Technique'],
                    'LEVEL 10' => ['Program atlet', 'Target lomba', 'Performance training']
                ];

                $studentLevel = strtoupper(trim($student['level'] ?? 'LEVEL 1'));
                $totalSkillsForLevel = count($skillsMap[$studentLevel] ?? $skillsMap['LEVEL 1']);

                $newProgress = 0;
                if ($totalSkillsForLevel > 0) {
                    $newProgress = round((count($skillsCompleted) / $totalSkillsForLevel) * 100);
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
