@extends('layouts.app')
@section('title', 'Add New Student')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-6">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h2 class="text-lg font-bold text-slate-800">Add New Student</h2>
            <p class="text-xs text-slate-400">Masukkan informasi siswa les renang baru</p>
        </div>
        <a href="{{ route('students.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-700">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap Siswa</label>
            <input type="text" name="name" required placeholder="Contoh: MAHREZ ANKA WARDANA"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-cyan-500 focus:bg-white transition">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Program</label>
                <select name="program" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    <option value="SEMI PRIVATE">SEMI PRIVATE</option>
                    <option value="GRUP">GRUP</option>
                    <option value="PRIVATE">PRIVATE</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Level</label>
                <select name="level" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    <option value="LEVEL 1">LEVEL 1</option>
                    <option value="LEVEL 2">LEVEL 2</option>
                    <option value="LEVEL 3">LEVEL 3</option>
                    <option value="ADVANCED">ADVANCED</option>
                </select>
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Simpan Siswa
            </button>
        </div>
    </form>
</div>
@endsection
