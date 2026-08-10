@extends('layouts.app')
@section('title', 'Detail Siswa - ' . $student->name)

@section('content')
<div class="space-y-6" id="content-area">

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('students.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition print:hidden">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Siswa
        </a>
        <div class="flex gap-2 print:hidden">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition shadow-sm">
                <i class="fa-solid fa-print mr-1"></i> Cetak Raport
            </button>
            <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg transition shadow-sm inline-flex items-center">
                <i class="fa-regular fa-pen-to-square mr-1"></i> Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Student Profile & Payment -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-cyan-100 text-cyan-600 rounded-full flex items-center justify-center text-4xl font-bold mb-4 shadow-sm">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-slate-800 uppercase">{{ $student->name }}</h2>
                    <p class="text-slate-500 font-medium text-sm mt-1">{{ $student->code }}</p>
                    
                    <span class="mt-4 px-4 py-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-sm font-bold uppercase tracking-wider">
                        {{ $student->level ?? 'BELUM ADA LEVEL' }}
                    </span>
                </div>

                <hr class="my-6 border-slate-100">

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Nickname</span>
                        <span class="font-medium text-slate-700 text-right">{{ explode(' ', $student->name)[0] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Gender</span>
                        <span class="font-medium text-slate-700 text-right">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Birth Date</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->age ? $student->age . ' Tahun' : '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Parent</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->parent_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Phone</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Pool</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->location ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Coach</span>
                        <span class="font-medium text-slate-700 text-right">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Program</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->program ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Level</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->level ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Schedule</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->schedule ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Join Date</span>
                        <span class="font-medium text-slate-700 text-right">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Status</span>
                        <span class="font-medium text-slate-700 text-right">{{ $student->status ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-wallet text-slate-400"></i> Status Pembayaran
                </h3>
                
                <div class="flex items-center justify-between p-4 rounded-xl {{ $paymentStatus === 'Lunas' ? 'bg-emerald-50 border border-emerald-100' : 'bg-rose-50 border border-rose-100' }}">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status Bulan Ini</p>
                        <p class="text-lg font-bold {{ $paymentStatus === 'Lunas' ? 'text-emerald-700' : 'text-rose-700' }}">
                            {{ $paymentStatus }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $paymentStatus === 'Lunas' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                        <i class="fa-solid {{ $paymentStatus === 'Lunas' ? 'fa-check' : 'fa-xmark' }} text-xl"></i>
                    </div>
                </div>
                
                @if($paymentStatus === 'Lunas')
                <p class="text-xs text-slate-500 mt-4 text-center">Telah dibayar: <span class="font-bold text-slate-700">{{ $student->nominal }}</span></p>
                @endif
            </div>
        </div>

        <!-- Right Column: Skills & Attendance -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Overall Progress -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Progress Belajar Keseluruhan</h3>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-slate-500">Tingkat Penyelesaian Level</span>
                    <span class="font-bold text-cyan-600 text-lg">{{ $student->progress ?? 0 }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-400 to-cyan-600 h-3 rounded-full transition-all duration-1000" style="width: {{ $student->progress ?? 0 }}%"></div>
                </div>
            </div>

            <!-- Skills Checklist -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-slate-400"></i> Skill yang Dilampaui ({{ $student->level ?? 'Level 1' }})
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($completedSkills as $skillName => $isCompleted)
                    <div class="flex items-start p-3 rounded-xl border {{ $isCompleted ? 'bg-emerald-50/50 border-emerald-100' : 'bg-slate-50 border-slate-200' }}">
                        <div class="flex-shrink-0 mt-0.5">
                            @if($isCompleted)
                                <div class="w-5 h-5 rounded bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded border-2 border-slate-300 bg-white"></div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium {{ $isCompleted ? 'text-slate-800' : 'text-slate-500' }}">{{ $skillName }}</p>
                            @if($isCompleted)
                            <p class="text-[10px] text-emerald-600 mt-0.5 font-semibold">Telah Dikuasai</p>
                            @else
                            <p class="text-[10px] text-slate-400 mt-0.5">Belum Dikuasai</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Catatan Coach -->
                <div class="mt-6 border-t border-slate-100 pt-5">
                    <h4 class="text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                        <i class="fa-regular fa-comment-dots text-slate-400"></i> Catatan Coach
                    </h4>
                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                        <p class="text-sm text-amber-800 leading-relaxed italic">
                            Belum ada catatan dari Coach untuk pertemuan ini.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-regular fa-calendar-check text-slate-400"></i> Kehadiran (8x Pertemuan)
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-center border-collapse">
                        <thead>
                            <tr>
                                @foreach($attendance as $att)
                                <th class="pb-3 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 w-1/8">
                                    Prt {{ $att['meeting'] }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($attendance as $att)
                                <td class="pt-4 pb-2">
                                    @if($att['status'] === 'Hadir')
                                        <div class="mx-auto w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-sm border border-emerald-200" title="Hadir">
                                            <i class="fa-solid fa-check text-lg"></i>
                                        </div>
                                    @elseif($att['status'] === 'Belum')
                                        <div class="mx-auto w-10 h-10 rounded-xl bg-slate-50 text-slate-300 flex items-center justify-center border border-slate-200 border-dashed" title="Belum dilaksanakan">
                                            <i class="fa-solid fa-minus text-sm"></i>
                                        </div>
                                    @else
                                        <div class="mx-auto w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shadow-sm border border-rose-200" title="Absen">
                                            <i class="fa-solid fa-xmark text-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($attendance as $att)
                                <td class="pt-1 text-[10px] font-semibold text-slate-500">
                                    {{ $att['status'] }}
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #content-area, #content-area * {
            visibility: visible;
        }
        #content-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .print\:hidden {
            display: none !important;
        }
    }
</style>
@endsection
