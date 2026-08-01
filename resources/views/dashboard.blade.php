@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-cyan-500">
        <p class="text-slate-500 text-sm">Total Acara</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalAcara ?? 12 }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-indigo-500">
        <p class="text-slate-500 text-sm">Total Seri</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalSeri ?? 34 }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-amber-500">
        <p class="text-slate-500 text-sm">Total Lomba</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalLomba ?? 210 }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-emerald-500">
        <p class="text-slate-500 text-sm">Total Club</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalClub ?? 58 }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Acara Terdekat</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500 border-b">
                    <th class="py-2">Nama Acara</th>
                    <th class="py-2">Tanggal</th>
                    <th class="py-2">Lokasi</th>
                    <th class="py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingAcara ?? [] as $acara)
                <tr class="border-b last:border-0">
                    <td class="py-3 font-medium text-slate-800">{{ $acara->nama }}</td>
                    <td class="py-3">{{ \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') }}</td>
                    <td class="py-3">{{ $acara->lokasi }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-xs bg-cyan-100 text-cyan-700">{{ $acara->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-3 text-slate-400">Belum ada acara terdekat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Club Teraktif</h2>
        <ul class="space-y-3">
            @forelse($topClubs ?? [] as $club)
            <li class="flex items-center justify-between">
                <span class="text-slate-700">{{ $club->nama }}</span>
                <span class="text-xs bg-slate-100 px-2 py-1 rounded-full">{{ $club->jumlah_atlet }} atlet</span>
            </li>
            @empty
            <li class="text-slate-400 text-sm">Belum ada data club.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
