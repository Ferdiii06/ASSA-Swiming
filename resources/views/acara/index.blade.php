@extends('layouts.app')
@section('title', 'Daftar Acara')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-slate-500">Kelola semua acara renang</p>
    @if(session('role', 'admin') !== 'parent')
    <a href="{{ route('acara.create') }}" class="bg-cyan-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-cyan-700">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Acara
    </a>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    @forelse($acaraList ?? [] as $acara)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-cyan-500 to-blue-600 flex items-center justify-center">
            <i class="fa-solid fa-trophy text-white text-4xl"></i>
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-slate-800">{{ $acara->nama }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($acara->tanggal)->format('d M Y') }}
            </p>
            <p class="text-sm text-slate-500">
                <i class="fa-solid fa-location-dot mr-1"></i> {{ $acara->lokasi }}
            </p>
            <div class="flex justify-between items-center mt-4">
                <span class="text-xs bg-cyan-100 text-cyan-700 px-2 py-1 rounded-full">{{ $acara->jumlah_seri }} Seri</span>
                <a href="{{ route('acara.show', $acara->id) }}" class="text-cyan-600 text-sm font-medium hover:underline">
                    Detail <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <p class="text-slate-400 col-span-3">Belum ada acara.</p>
    @endforelse
</div>
@endsection
