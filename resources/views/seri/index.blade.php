@extends('layouts.app')
@section('title', 'Manajemen Seri Pertandingan')

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
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Seri</span>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_seri'] ?? 34 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Seri Aktif</span>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['seri_aktif'] ?? 12 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-play"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Babak</span>
                <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $stats['total_babak'] ?? 8 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-flag-checkered"></i>
            </div>
        </div>
    </div>

    <!-- Search & Action Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('seri.index') }}" class="relative w-full sm:w-96">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama seri atau acara..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 shadow-sm transition">
        </form>

        <a href="{{ route('seri.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Seri
        </a>
    </div>

    <!-- Seri Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-5">Nama Seri</th>
                        <th class="py-3.5 px-5">Acara Induk</th>
                        <th class="py-3.5 px-5">Jumlah Lomba</th>
                        <th class="py-3.5 px-5">Tanggal</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($seriList as $seri)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-5 font-bold text-slate-800 tracking-wide">
                            {{ $seri->nama }}
                        </td>
                        <td class="py-4 px-5 text-slate-600 font-medium">
                            {{ $seri->acara_nama }}
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                                {{ $seri->jumlah_lomba }} Lomba
                            </span>
                        </td>
                        <td class="py-4 px-5 text-slate-500">
                            <i class="fa-regular fa-calendar text-slate-400 mr-1.5"></i>
                            {{ \Carbon\Carbon::parse($seri->tanggal)->format('d M Y') }}
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $seri->status === 'Mendatang' ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-slate-100 text-slate-600' }}">
                                {{ $seri->status }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('seri.show', $seri->id) }}" class="text-slate-400 hover:text-cyan-600 transition" title="Lihat Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <form action="{{ route('seri.destroy', $seri->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus seri ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            Belum ada data seri.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
