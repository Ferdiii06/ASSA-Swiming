@extends('layouts.guest')
@section('title', 'Menunggu Persetujuan - ASSA Swimming')

@section('content')
<div class="w-full animate-fade-in-up text-center" style="animation: fadeInUp 0.5s ease-out forwards;">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-100 text-amber-500 rounded-full mb-6">
            <i class="fa-solid fa-hourglass-half text-4xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-slate-800">Menunggu Persetujuan</h2>
        <p class="text-slate-500 mt-4 leading-relaxed">
            Pendaftaran Anda telah berhasil dicatat. Namun, akun Anda saat ini sedang dalam status <strong>Pending</strong>.<br>
            Mohon tunggu 1x24 jam hingga pendaftaran Anda diverifikasi dan disetujui oleh Coach.
        </p>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="mt-8">
        @csrf
        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all shadow-sm">
            Logout
        </button>
    </form>
</div>
@endsection
