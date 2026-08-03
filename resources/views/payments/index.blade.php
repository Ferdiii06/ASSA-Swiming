@extends('layouts.app')
@section('title', 'Daftar Pembayaran - ASSA Swimming')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-2">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Pembayaran (Verifikasi Manual)</h2>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg flex items-center gap-2 text-sm shadow-sm">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-sm font-semibold text-slate-600">
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Siswa</th>
                        <th class="py-4 px-6">Paket (Nominal)</th>
                        <th class="py-4 px-6">Bukti Transfer</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500">
                                {{ $payment->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-800">
                                {{ $payment->student_name }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold">{{ $payment->package->name ?? 'Paket Terhapus' }}</div>
                                <div class="text-xs text-slate-500">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @if($payment->proof_image)
                                    <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="text-cyan-600 hover:text-cyan-800 flex items-center gap-1 text-xs font-semibold">
                                        <i class="fa-solid fa-image"></i> Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-slate-400 italic text-xs">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($payment->status === 'success')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Approved
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                        Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($payment->status === 'pending')
                                    <form method="POST" action="{{ route('payments.approve', $payment->id) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" onclick="return confirm('Setujui pembayaran ini?')" class="bg-cyan-600 hover:bg-cyan-700 text-white p-2 rounded-lg text-xs font-medium transition shadow-sm" title="Approve Payment">
                                            <i class="fa-solid fa-check mr-1"></i> Approve
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-400 text-xs">- Selesai -</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-receipt text-4xl text-slate-200 mb-3"></i>
                                    <p>Belum ada data pembayaran.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
