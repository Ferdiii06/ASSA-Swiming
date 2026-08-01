<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LombaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $dummyLomba = collect([
            (object)[
                'id' => 1,
                'nama_nomor' => '50m Gaya Bebas Putra',
                'kategori' => 'KU-1 (15-17 Tahun)',
                'seri_nama' => 'Seri 1 - Penyisihan',
                'jumlah_peserta' => 24,
                'status' => 'Siap Dimulai',
            ],
            (object)[
                'id' => 2,
                'nama_nomor' => '100m Gaya Dada Putri',
                'kategori' => 'KU-2 (13-14 Tahun)',
                'seri_nama' => 'Seri 2 - Final',
                'jumlah_peserta' => 8,
                'status' => 'Berlangsung',
            ],
            (object)[
                'id' => 3,
                'nama_nomor' => '200m Gaya Kupu-Kupu Putra',
                'kategori' => 'Senior (> 18 Tahun)',
                'seri_nama' => 'Seri 3 - Semifinal',
                'jumlah_peserta' => 16,
                'status' => 'Mendatang',
            ],
            (object)[
                'id' => 4,
                'nama_nomor' => '4x100m Estafet Gaya Bebas Mixed',
                'kategori' => 'Umum',
                'seri_nama' => 'Seri 4 - Final',
                'jumlah_peserta' => 12,
                'status' => 'Selesai',
            ],
        ]);

        if ($search) {
            $dummyLomba = $dummyLomba->filter(function ($item) use ($search) {
                return stripos($item->nama_nomor, $search) !== false || stripos($item->kategori, $search) !== false;
            });
        }

        $stats = [
            'total_lomba' => 210,
            'peserta_terdaftar' => 540,
            'kategori_aktif' => 6,
        ];

        return view('lomba.index', [
            'lombaList' => $dummyLomba,
            'stats' => $stats,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('lomba.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('lomba.index')->with('success', 'Nomor lomba berhasil ditambahkan!');
    }

    public function show($id)
    {
        return redirect()->route('lomba.index');
    }

    public function destroy($id)
    {
        return redirect()->route('lomba.index')->with('success', 'Nomor lomba berhasil dihapus!');
    }
}
