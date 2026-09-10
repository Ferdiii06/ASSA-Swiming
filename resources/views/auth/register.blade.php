@extends('layouts.guest')
@section('title', 'Pendaftaran Siswa Baru - ASSA Swimming')

@section('content')
<div class="w-full animate-fade-in-up" style="animation: fadeInUp 0.5s ease-out forwards;">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-cyan-600 mb-6 transition-colors font-medium">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Pendaftaran Siswa</h2>
        <p class="text-slate-500 mt-2">Isi formulir di bawah ini untuk bergabung menjadi bagian dari ASSA Swimming.</p>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded mb-6 text-sm flex items-start">
            <i class="fa-solid fa-circle-exclamation mt-0.5 mr-3"></i>
            <div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6 text-sm flex items-center font-medium">
            <i class="fa-solid fa-check-circle mr-3 text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email (Untuk Login)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-slate-400"></i>
                </div>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-400"></i>
                </div>
                <input type="password" id="password" name="password" required minlength="8"
                       class="w-full pl-10 pr-12 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-cyan-600 focus:outline-none transition-colors">
                    <i id="eyeIcon" class="fa-regular fa-eye"></i>
                    <i id="eyeSlashIcon" class="fa-regular fa-eye-slash hidden"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 mt-2">
            Kirim Pendaftaran
        </button>
        
        <div class="text-center mt-6 text-sm text-slate-600">
            Sudah mendaftar dan punya akun? <a href="{{ route('login') }}" class="text-cyan-600 hover:text-cyan-700 font-semibold hover:underline">Login di sini</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        const eyeSlashIcon = document.querySelector('#eyeSlashIcon');

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                eyeIcon.classList.toggle('hidden');
                eyeSlashIcon.classList.toggle('hidden');
            });
        }
    });
</script>
@endsection
