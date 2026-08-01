<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
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
        return redirect()->route('students.index');
    }

    public function destroy($id)
    {
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
