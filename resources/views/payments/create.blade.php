@extends('layouts.app')
@section('title', 'Perpanjang Paket Les - ASSA Swimming')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-2">
        <h2 class="text-2xl font-bold text-slate-800">Perpanjang Paket Les (Pembayaran QRIS)</h2>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg flex items-center gap-2 text-sm shadow-sm">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col md:flex-row">
        <!-- Form Section -->
        <div class="p-6 md:p-8 flex-1 border-b md:border-b-0 md:border-r border-slate-100">
            <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Pilih Siswa -->
                    <div>
                        <label for="student_id" class="block text-sm font-semibold text-slate-700 mb-2">Nama Siswa</label>
                        <select name="student_id" id="student_id" required
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition @error('student_id') border-rose-500 @enderror">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->location ?? 'Tanpa Lokasi' }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Paket -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Paket Perpanjangan</label>
                        <div class="space-y-3">
                            @foreach($packages as $package)
                            <label class="flex items-start p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-cyan-50 hover:border-cyan-200 transition">
                                <div class="flex items-center h-5">
                                    <input type="radio" name="package_id" value="{{ $package->id }}" required class="w-4 h-4 text-cyan-600 border-slate-300 focus:ring-cyan-500">
                                </div>
                                <div class="ml-3 flex-1 flex justify-between items-center">
                                    <div>
                                        <span class="block text-sm font-semibold text-slate-800">{{ $package->name }}</span>
                                        <span class="block text-xs text-slate-500 mt-1">{{ $package->description }}</span>
                                    </div>
                                    <div class="text-sm font-bold text-cyan-600">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('package_id')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Bukti Bayar -->
                    <div>
                        <label for="proof_image" class="block text-sm font-semibold text-slate-700 mb-2">Upload Bukti Transfer</label>
                        <p class="text-xs text-slate-500 mb-2">Silakan scan QRIS di samping dan upload *screenshot* bukti transfer di sini.</p>
                        <input type="file" name="proof_image" id="proof_image" accept="image/*" required
                               class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition @error('proof_image') border-rose-500 @enderror">
                        @error('proof_image')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-3 rounded-xl text-sm font-bold transition shadow-md shadow-cyan-600/20">
                        Kirim Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>

        <!-- QRIS Section -->
        <div class="p-6 md:p-8 md:w-80 bg-slate-50 flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-bold text-slate-800 mb-2">Scan QRIS</h3>
            <p class="text-xs text-slate-500 mb-6">Pembayaran resmi ASSA Swimming Course. Diterima oleh semua M-Banking & E-Wallet.</p>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-4 relative">
                <!-- Placeholder Image for QRIS -->
                <!-- We use a placeholder image service representing a QR code -->
                <img src="images/Qrispembayaran.jpeg" alt="QRIS ASSA Swimming" class="w-48 h-48 object-contain">

                <!-- Overlay for aesthetic -->
                <div class="absolute inset-0 border-4 border-cyan-500/20 rounded-2xl pointer-events-none"></div>
            </div>

            <div class="flex items-center gap-2 text-slate-600 text-sm font-medium">
                <i class="fa-solid fa-shield-check text-emerald-500"></i> Pembayaran Aman
            </div>
        </div>
    </div>
</div>
@endsection
