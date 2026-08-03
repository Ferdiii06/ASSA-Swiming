@extends('layouts.app')
@section('title', 'Manajemen Nomor Lomba')

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
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Nomor Lomba</span>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_lomba'] ?? 210 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-person-swimming"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Peserta Terdaftar</span>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['peserta_terdaftar'] ?? 540 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-group"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori Aktif</span>
                <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['kategori_aktif'] ?? 6 }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-trophy"></i>
            </div>
        </div>
    </div>

    <!-- Search & Action Toolbar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('lomba.index') }}" class="relative w-full sm:w-96">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nomor lomba atau kategori..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 shadow-sm transition">
        </form>

        @if(session('role', 'admin') !== 'parent')
        <a href="{{ route('lomba.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Lomba
        </a>
        @endif
    </div>

    <!-- Lomba Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-5">Nomor Lomba</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5">Seri</th>
                        <th class="py-3.5 px-5">Jumlah Peserta</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($lombaList as $lomba)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-5 font-bold text-slate-800 tracking-wide">
                            {{ $lomba->nama_nomor }}
                        </td>
                        <td class="py-4 px-5 text-slate-600 font-medium">
                            {{ $lomba->kategori }}
                        </td>
                        <td class="py-4 px-5 text-slate-600">
                            {{ $lomba->seri_nama }}
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                {{ $lomba->jumlah_peserta }} Atlet
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            @if($lomba->status === 'Berlangsung')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                    {{ $lomba->status }}
                                </span>
                            @elseif($lomba->status === 'Siap Dimulai')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-cyan-50 text-cyan-600 border border-cyan-200">
                                    {{ $lomba->status }}
                                </span>
                            @elseif($lomba->status === 'Selesai')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    {{ $lomba->status }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 border border-amber-200">
                                    {{ $lomba->status }}
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('lomba.show', $lomba->id) }}" class="text-slate-400 hover:text-cyan-600 transition" title="Lihat Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                @if(session('role', 'admin') !== 'parent')
                                <form action="{{ route('lomba.destroy', $lomba->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nomor lomba ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            Belum ada data nomor lomba.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
