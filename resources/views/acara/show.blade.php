@extends('layouts.app')
@section('title', $acara->nama ?? 'Detail Acara')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-bold text-slate-800">{{ $acara->nama }}</h2>
            <p class="text-slate-500 mt-1">
                <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') }}
                &nbsp;•&nbsp;
                <i class="fa-solid fa-location-dot mr-1"></i> {{ $acara->lokasi }}
            </p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs bg-cyan-100 text-cyan-700">{{ $acara->status }}</span>
    </div>
</div>

<h3 class="font-semibold text-slate-800 mb-3">Daftar Seri</h3>
<div class="space-y-4">
    @forelse($acara->seri ?? [] as $seri)
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-medium text-slate-800">{{ $seri->nama }}</h4>
            <a href="{{ route('seri.show', $seri->id) }}" class="text-cyan-600 text-sm hover:underline">Lihat Lomba &rarr;</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @forelse($seri->lomba ?? [] as $lomba)
            <div class="border rounded-lg p-3 text-sm">
                <p class="font-medium text-slate-700">{{ $lomba->nama_nomor }}</p>
                <p class="text-slate-500 text-xs mt-1">{{ $lomba->kategori }}</p>
            </div>
            @empty
            <p class="text-slate-400 text-sm col-span-4">Belum ada lomba di seri ini.</p>
            @endforelse
        </div>
    </div>
    @empty
    <p class="text-slate-400">Belum ada seri untuk acara ini.</p>
    @endforelse
</div>
@endsection
