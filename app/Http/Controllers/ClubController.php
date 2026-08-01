<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $dummyClub = collect([
            (object)[
                'id' => 1,
                'nama' => 'ASSA Swimming Club',
                'kota' => 'Surabaya',
                'pelatih_utama' => 'Coach Budi Santoso',
                'jumlah_atlet' => 48,
                'status' => 'Aktif',
            ],
            (object)[
                'id' => 2,
                'nama' => 'Dolphin Aquatics Club',
                'kota' => 'Malang',
                'pelatih_utama' => 'Coach Anita Wijaya',
                'jumlah_atlet' => 32,
                'status' => 'Aktif',
            ],
            (object)[
                'id' => 3,
                'nama' => 'Kraken Swim Academy',
                'kota' => 'Sidoarjo',
                'pelatih_utama' => 'Coach Hendra Setiawan',
                'jumlah_atlet' => 25,
                'status' => 'Aktif',
            ],
            (object)[
                'id' => 4,
                'nama' => 'Poseidon Swimming Team',
                'kota' => 'Gresik',
                'pelatih_utama' => 'Coach Rian Agung',
                'jumlah_atlet' => 19,
                'status' => 'Pending Verifikasi',
            ],
        ]);

        if ($search) {
            $dummyClub = $dummyClub->filter(function ($item) use ($search) {
                return stripos($item->nama, $search) !== false || stripos($item->kota, $search) !== false;
            });
        }

        $stats = [
            'total_club' => 58,
            'total_atlet' => 320,
            'total_kota' => 14,
        ];

        return view('club.index', [
            'clubList' => $dummyClub,
            'stats' => $stats,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('club.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('club.index')->with('success', 'Klub berhasil mendaftar!');
    }

    public function show($id)
    {
        return redirect()->route('club.index');
    }

    public function destroy($id)
    {
        return redirect()->route('club.index')->with('success', 'Klub berhasil dihapus!');
    }
}
