@extends('layouts.guest')
@section('title', 'Verifikasi Email - ASSA Swimming')

@section('content')
<div class="w-full animate-fade-in-up" style="animation: fadeInUp 0.5s ease-out forwards;">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-cyan-100 mb-4 text-cyan-600 text-2xl">
            <i class="fa-regular fa-envelope"></i>
        </div>
        <h2 class="text-3xl font-bold text-slate-800">Cek Email Anda</h2>
        <p class="text-slate-500 mt-3 text-sm leading-relaxed">
            Terima kasih telah mendaftar! Sebelum mulai menggunakan dashboard, harap verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan.
        </p>
    </div>

    @if (session('message'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6 text-sm flex items-center font-medium">
            <i class="fa-solid fa-check-circle mr-3 text-lg"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 text-center mb-6">
        <p class="text-sm text-slate-600 mb-4">Jika Anda tidak menerima email verifikasi, klik tombol di bawah ini untuk mengirim ulang.</p>
        
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-3 px-4 rounded-xl transition-all shadow hover:shadow-md">
                Kirim Ulang Email Verifikasi
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="text-sm text-slate-500 hover:text-rose-600 font-medium transition-colors hover:underline">
            Batal dan Logout
        </button>
    </form>
</div>
@endsection
