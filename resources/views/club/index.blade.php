@extends('layouts.app')
@section('title', 'Manajemen Club Renang')

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

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Club</span>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_club'] ?? 58 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-people-group"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Atlet Terdaftar</span>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['total_atlet'] ?? 320 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-person-swimming"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kota Asal</span>
                <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $stats['total_kota'] ?? 14 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-city"></i>
            </div>
        </div>
    </div>

    <!-- Search & Action Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('club.index') }}" class="relative w-full sm:w-96">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama club atau kota..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 shadow-sm transition">
        </form>

        @if(session('role', 'admin') !== 'parent')
        <a href="{{ route('club.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Club
        </a>
        @endif
    </div>

    <!-- Club Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($clubList as $club)
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between hover:border-cyan-200 hover:shadow-md transition">
            <div>
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr($club->nama, 0, 2)) }}
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $club->status === 'Aktif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200' }}">
                        {{ $club->status }}
                    </span>
                </div>
                <h3 class="font-bold text-slate-800 mt-4 text-base tracking-wide">{{ $club->nama }}</h3>
                <p class="text-xs text-slate-400 mt-1 font-medium">
                    <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> {{ $club->kota }}
                </p>
                <p class="text-xs text-slate-500 mt-2">
                    <i class="fa-solid fa-user-tie text-slate-400 mr-1"></i> {{ $club->pelatih_utama }}
                </p>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">
                    {{ $club->jumlah_atlet }} Atlet
                </span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('club.show', $club->id) }}" class="text-slate-400 hover:text-cyan-600 text-sm transition" title="Lihat Profil">
                        <i class="fa-regular fa-eye"></i>
                    </a>
                    @if(session('role', 'admin') !== 'parent')
                    <form action="{{ route('club.destroy', $club->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus club ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-rose-600 text-sm transition" title="Hapus">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-xl p-8 text-center text-slate-400 border border-slate-100">
            Belum ada club terdaftar.
        </div>
        @endforelse
    </div>

</div>
@endsection
