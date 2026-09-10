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

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Gender (Jenis Kelamin)</label>
                    <select name="gender" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        <option value="">-- Pilih Gender --</option>
                        <option value="Laki-laki" {{ (old('gender', $student->gender ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ (old('gender', $student->gender ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Coach -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Coach (Pelatih)</label>
                    <select name="coach_name" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        <option value="">-- Pilih Coach --</option>
                        @foreach($coaches as $coach)
                            <option value="{{ $coach->name }}" {{ (old('coach_name', $student->coach_name ?? '') == $coach->name) ? 'selected' : '' }}>{{ $coach->name }}</option>
                        @endforeach
                    </select>
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
                    <input type="text" name="location" value="{{ old('location', $student->location ?? '') }}" required placeholder="Contoh: Kolam Delta" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Program -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Program</label>
                    <input type="text" name="program" value="{{ old('program', $student->program ?? '') }}" required placeholder="Contoh: PRIVATE" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                </div>

                <!-- Level -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Level Kelas</label>
                    <select name="level" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        <option value="LEVEL 1" {{ (old('level', $student->level ?? '') == 'LEVEL 1') ? 'selected' : '' }}>LEVEL 1 - Water Discovery</option>
                        <option value="LEVEL 2" {{ (old('level', $student->level ?? '') == 'LEVEL 2') ? 'selected' : '' }}>LEVEL 2 - Water Confidence</option>
                        <option value="LEVEL 3" {{ (old('level', $student->level ?? '') == 'LEVEL 3') ? 'selected' : '' }}>LEVEL 3 - Basic Swimming</option>
                        <option value="LEVEL 4" {{ (old('level', $student->level ?? '') == 'LEVEL 4') ? 'selected' : '' }}>LEVEL 4 - Intermediate Swimming</option>
                        <option value="LEVEL 5" {{ (old('level', $student->level ?? '') == 'LEVEL 5') ? 'selected' : '' }}>LEVEL 5 - Advanced Swimming</option>
                        <option value="LEVEL 6" {{ (old('level', $student->level ?? '') == 'LEVEL 6') ? 'selected' : '' }}>LEVEL 6 - Swim Champion</option>
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
