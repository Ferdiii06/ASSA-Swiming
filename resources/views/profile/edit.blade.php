@extends('layouts.app')
@section('title', 'My Profile - ASSA Swimming')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-2">
        <h2 class="text-2xl font-bold text-slate-800">My Profile</h2>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg flex items-center gap-2 text-sm shadow-sm">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <!-- Profile Header / Avatar -->
                    <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
                        <div class="w-16 h-16 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-2xl shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ $user->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition @error('name') border-rose-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-slate-100 mt-6 mb-4">
                        <h4 class="text-sm font-semibold text-slate-800 mb-4">Ubah Password (Opsional)</h4>
                        <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password.</p>
                        
                        <div class="space-y-4">
                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition @error('password') border-rose-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
