@extends('layouts.app')
@section('title', 'Student Management Dashboard - ASSA Swimming School')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg flex justify-between items-center text-sm shadow-sm">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Stat Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Students -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Students</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-3xl font-bold text-slate-800">{{ $stats['total_students'] ?? 0 }}</span>
                <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Active -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Active</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-3xl font-bold text-emerald-600">{{ $stats['active_students'] ?? 0 }}</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
        </div>

        <!-- Avg Progress -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Avg Progress</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-3xl font-bold text-amber-500">{{ $stats['avg_progress'] ?? 0 }}%</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex flex-col justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Paid (Pembayaran)</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-3xl font-bold text-indigo-600">{{ $stats['paid_students'] ?? 0 }}</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Toolbar -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('students.index') }}" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-72">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search student name or ID..."
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-cyan-500 transition">
            </div>

            <!-- Location Filter -->
            <select name="location" onchange="this.form.submit()" class="w-full sm:w-52 py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-cyan-500">
                <option value="">Semua Kolam Renang</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                @endforeach
            </select>

            <!-- Program Filter -->
            <select name="program" onchange="this.form.submit()" class="w-full sm:w-40 py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-cyan-500">
                <option value="">Semua Program</option>
                @foreach($programs as $prog)
                    <option value="{{ $prog }}" {{ request('program') == $prog ? 'selected' : '' }}>{{ $prog }}</option>
                @endforeach
            </select>

            <!-- Per Page Selector -->
            <select name="per_page" onchange="this.form.submit()" class="w-full sm:w-32 py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-700 focus:outline-none focus:border-cyan-500">
                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 / Halaman</option>
                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30 / Halaman</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / Halaman</option>
                <option value="-1" {{ request('per_page') == -1 ? 'selected' : '' }}>Semua (144)</option>
            </select>

            @if(request('search') || request('location') || request('program') || request('per_page'))
                <a href="{{ route('students.index') }}" class="text-xs font-semibold text-rose-500 hover:underline whitespace-nowrap">Reset Filter</a>
            @endif
        </form>

        <!-- Add Student Button -->
        @auth
        <a href="{{ route('students.create') }}" class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-5 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-xl shadow-sm transition whitespace-nowrap">
            <i class="fa-solid fa-plus text-xs"></i> Add Student
        </a>
        @endauth
    </div>

    <!-- Students Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-5">Student</th>
                        <th class="py-3.5 px-5">Program & Kolam</th>
                        <th class="py-3.5 px-5">Level & Jadwal</th>
                        <th class="py-3.5 px-5">Progress</th>
                        <th class="py-3.5 px-5">Status</th>
                        @auth
                        <th class="py-3.5 px-5 text-right">Actions</th>
                        @endauth
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- Student Name & Code -->
                        <td class="py-4 px-5">
                            <div class="font-bold text-slate-800 tracking-wide uppercase">{{ $student->name }}</div>
                            <div class="text-xs text-slate-400 mt-0.5 font-medium flex items-center gap-2">
                                <span>{{ $student->code }}</span>
                                @if(!empty($student->parent_name))
                                    <span>• Ortu: {{ $student->parent_name }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Program & Location -->
                        <td class="py-4 px-5">
                            <span class="inline-block font-semibold text-slate-700 uppercase text-xs bg-slate-100 px-2 py-0.5 rounded">
                                {{ $student->program }}
                            </span>
                            @if(!empty($student->location))
                                <div class="text-xs text-cyan-700 font-medium mt-1">
                                    <i class="fa-solid fa-location-dot text-cyan-500 mr-1"></i>{{ $student->location }}
                                </div>
                            @endif
                        </td>

                        <!-- Level & Schedule -->
                        <td class="py-4 px-5">
                            <div class="font-semibold text-slate-700 uppercase text-xs">
                                {{ $student->level }}
                            </div>
                            @if(!empty($student->schedule))
                                <div class="text-xs text-slate-500 mt-0.5">
                                    <i class="fa-regular fa-clock text-slate-400 mr-1"></i>{{ $student->schedule }}
                                </div>
                            @endif
                        </td>

                        <!-- Progress Bar & % -->
                        <td class="py-4 px-5 w-44">
                            <div class="flex flex-col gap-1.5">
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-amber-400 h-2 rounded-full transition-all duration-300" style="width: {{ $student->progress }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-500">{{ $student->progress }}%</span>
                            </div>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-200">
                                {{ $student->status }}
                            </span>
                        </td>

                        <!-- Actions -->
                        @auth
                        <td class="py-4 px-5 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('students.show', $student->id) }}" class="text-slate-400 hover:text-cyan-600 transition" title="View Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endauth
                    </tr>
                    @empty
                    <tr>
                        @auth
                        <td colspan="6" class="py-8 text-center text-slate-400">
                        @else
                        <td colspan="5" class="py-8 text-center text-slate-400">
                        @endauth
                            No students found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if($students->hasPages() || $students->total() > 0)
        <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-medium">
            <div>
                Menampilkan <span class="font-bold text-slate-700">{{ $students->firstItem() ?? 0 }}</span> sampai <span class="font-bold text-slate-700">{{ $students->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-700">{{ $students->total() }}</span> siswa
            </div>
            
            @if($students->hasPages())
            <div class="inline-flex items-center gap-1">
                {{-- Previous Page Link --}}
                @if ($students->onFirstPage())
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $students->previousPageUrl() }}" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition shadow-sm">Previous</a>
                @endif

                {{-- Page Links --}}
                @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                    @if ($page == $students->currentPage())
                        <span class="px-3 py-1.5 bg-cyan-600 text-white font-bold rounded-lg shadow-sm">{{ $page }}</span>
                    @elseif ($page == 1 || $page == $students->lastPage() || abs($page - $students->currentPage()) <= 1)
                        <a href="{{ $url }}" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition shadow-sm">{{ $page }}</a>
                    @elseif (abs($page - $students->currentPage()) == 2)
                        <span class="px-1 text-slate-400">...</span>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($students->hasMorePages())
                    <a href="{{ $students->nextPageUrl() }}" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition shadow-sm">Next</a>
                @else
                    <span class="px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg cursor-not-allowed">Next</span>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>

</div>
@endsection
