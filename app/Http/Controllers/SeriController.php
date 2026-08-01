<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $dummySeri = collect([
            (object)[
                'id' => 1,
                'nama' => 'Seri 1 - Penyisihan Gaya Bebas',
                'acara_nama' => 'Kejuaraan Renang Antar Klub 2026',
                'jumlah_lomba' => 8,
                'tanggal' => '2026-08-15',
                'status' => 'Mendatang',
            ],
            (object)[
                'id' => 2,
                'nama' => 'Seri 2 - Final Gaya Dada 100m',
                'acara_nama' => 'Kejuaraan Renang Antar Klub 2026',
                'jumlah_lomba' => 4,
                'tanggal' => '2026-08-15',
                'status' => 'Mendatang',
            ],
            (object)[
                'id' => 3,
                'nama' => 'Seri 3 - Semifinal Gaya Kupu-Kupu',
                'acara_nama' => 'Olimpiade Renang Pelajar Jatim',
                'jumlah_lomba' => 6,
                'tanggal' => '2026-09-02',
                'status' => 'Draf',
            ],
            (object)[
                'id' => 4,
                'nama' => 'Seri 4 - Estafet 4x100m Gaya Bebas',
                'acara_nama' => 'Olimpiade Renang Pelajar Jatim',
                'jumlah_lomba' => 5,
                'tanggal' => '2026-09-03',
                'status' => 'Draf',
            ],
        ]);

        if ($search) {
            $dummySeri = $dummySeri->filter(function ($item) use ($search) {
                return stripos($item->nama, $search) !== false || stripos($item->acara_nama, $search) !== false;
            });
        }

        $stats = [
            'total_seri' => 34,
            'seri_aktif' => 12,
            'total_babak' => 8,
        ];

        return view('seri.index', [
            'seriList' => $dummySeri,
            'stats' => $stats,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('seri.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('seri.index')->with('success', 'Seri berhasil ditambahkan!');
    }

    public function show($id)
    {
        return redirect()->route('seri.index');
    }

    public function destroy($id)
    {
        return redirect()->route('seri.index')->with('success', 'Seri berhasil dihapus!');
    }
}
