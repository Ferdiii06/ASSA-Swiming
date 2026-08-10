@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

@if(isset($isParent) && $isParent)
    <!-- PARENT DASHBOARD -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Orang Tua</h1>
        <p class="text-gray-500 text-sm mt-1">Pantau perkembangan, jadwal, dan pembayaran anak Anda.</p>
    </div>

    @if($students->count() > 0)
        @foreach($students as $student)
            <div class="mb-8 bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                
                <!-- Student Header -->
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl border border-blue-100">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $student->name }}</h2>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="w-2 h-2 rounded-full {{ $student->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            <span class="text-sm text-gray-600">
                                {{ $student->is_active ? 'Siswa Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- 1. Progres & Evaluasi -->
                    @php $latestReport = $student->progressReports->first(); @endphp
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-chart-line text-blue-500"></i>
                            <h3 class="font-semibold text-gray-800">Progres & Evaluasi</h3>
                        </div>
                        
                        @if($latestReport)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Level Kemampuan</p>
                                        <p class="font-medium text-gray-800">{{ current(explode('|', $latestReport->level)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Materi Dikuasai</p>
                                        <p class="font-medium text-gray-800 truncate" title="{{ $latestReport->skills_achieved }}">{{ $latestReport->skills_achieved ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 mb-1">Catatan Coach</p>
                                    <p class="text-sm text-gray-700 italic bg-white p-3 rounded border border-gray-100">"{{ $latestReport->instructor_notes ?? 'Belum ada catatan.' }}"</p>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600">Persentase Progres</span>
                                        <span class="font-medium text-gray-800">{{ $latestReport->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $latestReport->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                <p class="text-sm text-gray-500">Belum ada data progres (raport belum diisi).</p>
                            </div>
                        @endif
                    </div>

                    <!-- 2. Jadwal & Kehadiran -->
                    @php $activeEnrollment = $student->enrollments->first(); @endphp
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-calendar-check text-emerald-500"></i>
                            <h3 class="font-semibold text-gray-800">Jadwal Latihan & Kehadiran</h3>
                        </div>
                        
                        @if($activeEnrollment && $activeEnrollment->schedule)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 space-y-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Waktu & Coach</p>
                                    <p class="font-medium text-gray-800">{{ $activeEnrollment->schedule->day_name }}, {{ $activeEnrollment->schedule->start_time->format('H:i') }} - {{ $activeEnrollment->schedule->end_time->format('H:i') }}</p>
                                    <p class="text-sm text-gray-600 mt-0.5">Coach: {{ $activeEnrollment->schedule->coach->name ?? '-' }}</p>
                                </div>
                                
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600">Kehadiran (Berdasarkan Raport)</span>
                                        @if($latestReport)
                                            <span class="font-medium text-gray-800">{{ $latestReport->attendance }} / {{ $latestReport->total_sessions }} Sesi</span>
                                        @endif
                                    </div>
                                    @if($latestReport)
                                        <div class="w-full flex gap-1 h-2">
                                            @for($i = 1; $i <= $latestReport->total_sessions; $i++)
                                                <div class="flex-1 rounded-sm {{ $i <= $latestReport->attendance ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>
                                            @endfor
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-500">Data kehadiran belum tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                                <p class="text-sm text-gray-500">Belum ada jadwal latihan aktif.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pembayaran -->
                @php $latestPayment = $student->payments->first(); @endphp
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-file-invoice-dollar text-amber-500"></i>
                        <h3 class="font-semibold text-gray-800">Status Pembayaran</h3>
                    </div>
                    
                    @if($latestPayment)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Tagihan Terakhir</p>
                                    <p class="font-medium text-gray-800">Rp {{ number_format($latestPayment->amount, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">{{ $latestPayment->payment_date ? $latestPayment->payment_date->format('d M Y') : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Status</p>
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded {{ in_array(strtolower($latestPayment->status), ['verified', 'paid', 'lunas']) ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ in_array(strtolower($latestPayment->status), ['verified', 'paid', 'lunas']) ? 'LUNAS' : strtoupper($latestPayment->status) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Sisa Pertemuan</p>
                                    @if($latestReport)
                                        <p class="font-medium text-gray-800">{{ max(0, $latestReport->total_sessions - $latestReport->attendance) }} Sesi</p>
                                    @else
                                        <p class="text-sm text-gray-500">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                            <p class="text-sm text-gray-500">Belum ada riwayat pembayaran.</p>
                        </div>
                    @endif
                </div>

            </div>
        @endforeach
    @else
        <div class="bg-white p-8 rounded-xl border border-gray-200 text-center text-gray-500">
            <p>Belum ada data anak yang terdaftar pada akun Anda.</p>
        </div>
    @endif

@else
    <!-- ADMIN / GENERAL DASHBOARD -->
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di ASSA Swimming</h1>
        <p class="text-gray-500 text-sm mt-1">Portal informasi kegiatan, jadwal perlombaan, dan pengelolaan data klub renang.</p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        


    </div>

    @if(!Auth::check())
    <!-- Notice for Guest -->
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 flex items-start gap-4">
        <div class="mt-0.5 text-blue-500">
            <i class="fa-solid fa-circle-info text-xl"></i>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-blue-900">Akses Khusus Pelatih (Coach)</h4>
            <p class="text-sm text-blue-700 mt-1 mb-3">Untuk mengelola data siswa dan melakukan penilaian (raport), silakan login terlebih dahulu menggunakan akun Coach Anda.</p>
            <a href="{{ route('login') }}" class="text-sm font-medium text-blue-700 hover:text-blue-800 underline decoration-blue-300 underline-offset-4">
                Buka Halaman Login &rarr;
            </a>
        </div>
    </div>
    @endif
@endif

@endsection
