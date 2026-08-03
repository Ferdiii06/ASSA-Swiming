@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di ASSA Swimming</h1>
    <p class="text-gray-500 text-sm mt-1">Portal informasi kegiatan, jadwal perlombaan, dan pengelolaan data klub renang.</p>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    
    <!-- Card: Acara -->
    <a href="{{ route('acara.index') }}" class="block bg-white p-6 rounded-xl border border-gray-200 hover:border-cyan-500 hover:shadow-sm transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600">
                <i class="fa-solid fa-calendar-days text-xl"></i>
            </div>
            @if(isset($totalAcara) && $totalAcara > 0)
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $totalAcara }} Item</span>
            @endif
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Jadwal Acara</h3>
        <p class="text-sm text-gray-500">Informasi agenda kegiatan renang dan kompetisi.</p>
    </a>

    <!-- Card: Lomba -->
    <a href="{{ route('lomba.index') }}" class="block bg-white p-6 rounded-xl border border-gray-200 hover:border-cyan-500 hover:shadow-sm transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fa-solid fa-person-swimming text-xl"></i>
            </div>
            @if(isset($totalLomba) && $totalLomba > 0)
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $totalLomba }} Item</span>
            @endif
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Perlombaan</h3>
        <p class="text-sm text-gray-500">Hasil pertandingan dan detail perlombaan.</p>
    </a>

    <!-- Card: Seri -->
    <a href="{{ route('seri.index') }}" class="block bg-white p-6 rounded-xl border border-gray-200 hover:border-cyan-500 hover:shadow-sm transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fa-solid fa-layer-group text-xl"></i>
            </div>
            @if(isset($totalSeri) && $totalSeri > 0)
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $totalSeri }} Item</span>
            @endif
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Seri Pertandingan</h3>
        <p class="text-sm text-gray-500">Pengelompokan berdasarkan gaya dan kategori.</p>
    </a>

    <!-- Card: Club -->
    <a href="{{ route('club.index') }}" class="block bg-white p-6 rounded-xl border border-gray-200 hover:border-cyan-500 hover:shadow-sm transition-all duration-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                <i class="fa-solid fa-people-group text-xl"></i>
            </div>
            @if(isset($totalClub) && $totalClub > 0)
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $totalClub }} Item</span>
            @endif
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Daftar Klub</h3>
        <p class="text-sm text-gray-500">Informasi klub renang yang terdaftar.</p>
    </a>

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

@endsection
