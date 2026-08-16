@extends('layouts.app')
@section('title', 'Edit Data Siswa - ' . $student->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('students.show', $student->id) }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Batal & Kembali
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">
            <i class="fa-regular fa-pen-to-square text-cyan-500 mr-2"></i> Edit Profil Siswa
        </h2>
        
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $student->name ?? '') }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>
                
                <!-- Usia -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Usia (Tahun)</label>
                    <input type="number" name="age" value="{{ old('age', $student->age ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Nama Orang Tua -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Orang Tua</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Nomor HP / WA -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Kolam / Lokasi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Lokasi Kolam</label>
                    <input type="text" name="location" value="{{ old('location', $student->location ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Program -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Program</label>
                    <input type="text" name="program" value="{{ old('program', $student->program ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Level -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Level Kelas</label>
                    <select name="level" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        <option value="LEVEL 1" {{ (old('level', $student->level ?? '') == 'LEVEL 1') ? 'selected' : '' }}>Level 1</option>
                        <option value="LEVEL 2" {{ (old('level', $student->level ?? '') == 'LEVEL 2') ? 'selected' : '' }}>Level 2</option>
                        <option value="LEVEL 3" {{ (old('level', $student->level ?? '') == 'LEVEL 3') ? 'selected' : '' }}>Level 3</option>
                        <option value="LEVEL 4" {{ (old('level', $student->level ?? '') == 'LEVEL 4') ? 'selected' : '' }}>Level 4</option>
                        <option value="LEVEL 5" {{ (old('level', $student->level ?? '') == 'LEVEL 5') ? 'selected' : '' }}>Level 5</option>
                        <option value="LEVEL 6" {{ (old('level', $student->level ?? '') == 'LEVEL 6') ? 'selected' : '' }}>Level 6</option>
                        <option value="LEVEL 7" {{ (old('level', $student->level ?? '') == 'LEVEL 7') ? 'selected' : '' }}>Level 7</option>
                        <option value="LEVEL 8" {{ (old('level', $student->level ?? '') == 'LEVEL 8') ? 'selected' : '' }}>Level 8</option>
                        <option value="LEVEL 9" {{ (old('level', $student->level ?? '') == 'LEVEL 9') ? 'selected' : '' }}>Level 9</option>
                        <option value="LEVEL 10" {{ (old('level', $student->level ?? '') == 'LEVEL 10') ? 'selected' : '' }}>Level 10</option>
                        <option value="TIDAK ADA" {{ (old('level', $student->level ?? '') == 'TIDAK ADA') ? 'selected' : '' }}>Tidak Ada Level</option>
                    </select>
                </div>

                <!-- Jadwal -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Jadwal (Hari & Jam)</label>
                    <input type="text" name="schedule" value="{{ old('schedule', $student->schedule ?? '') }}" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Paket Pertemuan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Paket Pertemuan</label>
                    <select name="package_meetings" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        <option value="8" {{ (old('package_meetings', $student->package_meetings ?? 8) == 8) ? 'selected' : '' }}>8 Kali Pertemuan</option>
                        <option value="4" {{ (old('package_meetings', $student->package_meetings ?? 8) == 4) ? 'selected' : '' }}>4 Kali Pertemuan</option>
                    </select>
                </div>
                
                <!-- Pembayaran / Nominal -->
                <div class="md:col-span-2 mt-4 pt-4 border-t border-slate-100">
                    <label class="block text-sm font-bold text-slate-700 mb-1">
                        <i class="fa-solid fa-wallet text-slate-400 mr-1"></i> Data Pembayaran Terakhir
                    </label>
                    <p class="text-xs text-slate-500 mb-2">Kosongkan kolom ini jika siswa belum membayar bulan ini. Jika sudah bayar, isi dengan nominal atau tanggal (misal: "Rp 350.000"). Ini akan mengubah status menjadi Lunas.</p>
                    <input type="text" name="nominal" value="{{ old('nominal', $student->nominal ?? '') }}" class="w-full md:w-1/2 rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3" placeholder="Contoh: Rp 350.000">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('students.show', $student->id) }}" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-xl transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
