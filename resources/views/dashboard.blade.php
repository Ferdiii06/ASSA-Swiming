@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<!-- Background Image Watermark -->
<div class="fixed inset-0 z-0 pointer-events-none flex items-center justify-center opacity-[0.03]">
    <img src="{{ asset('images/ASSAswim.png') }}" alt="Background" class="max-w-md md:max-w-xl lg:max-w-2xl w-full object-contain grayscale">
</div>

<div class="relative z-10">

@if(isset($isParent) && $isParent)
    <!-- PARENT DASHBOARD -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Orang Tua</h1>
        <p class="text-gray-500 text-sm mt-1">Pantau perkembangan, jadwal, dan pembayaran anak Anda.</p>
    </div>

    @if(empty(auth()->user()->phone))
        <div class="bg-amber-50 p-8 rounded-xl border border-amber-200 shadow-sm mb-8">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-amber-100 rounded-full text-amber-600">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-lg font-bold text-amber-800 mb-2">Lengkapi Profil Anda</h2>
                    <p class="text-amber-700 text-sm mb-4">
                        Untuk menyambungkan akun ini dengan data anak Anda yang didaftarkan oleh Coach, Anda <b>wajib</b> melengkapi Nama Asli dan Nomor WhatsApp yang sesuai.
                    </p>
                    
                    <form action="{{ route('profile.complete') }}" method="POST" class="max-w-md space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-amber-800 mb-1">Nama Asli Anda</label>
                            <input type="text" name="name" required placeholder="Sesuai yang didaftarkan ke Coach" value="{{ auth()->user()->name }}"
                                   class="w-full px-4 py-2.5 bg-white border border-amber-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-amber-800 mb-1">Nomor WhatsApp</label>
                            <input type="text" name="phone" required placeholder="Contoh: 08123456789"
                                   class="w-full px-4 py-2.5 bg-white border border-amber-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-amber-500 transition">
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                            Simpan Profil & Sambungkan Anak
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @elseif($students->count() > 0)
        @foreach($students as $student)
            <div class="mb-8 bg-white rounded-xl p-6 border border-gray-200 shadow-sm">

                <!-- Student Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl border border-blue-100">
                            {{ substr($student->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $student->name ?? '-' }}</h2>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="w-2 h-2 rounded-full {{ ($student->status ?? 'Active') === 'Active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <span class="text-sm text-gray-600">
                                    {{ ($student->status ?? 'Active') === 'Active' ? 'Siswa Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('students.show', $student->id ?? 0) }}" class="inline-block px-4 py-2 bg-cyan-50 text-cyan-700 hover:bg-cyan-100 rounded-lg text-sm font-semibold transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- 1. Progres -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-chart-line text-blue-500"></i>
                            <h3 class="font-semibold text-gray-800">Progres Belajar</h3>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Level Kemampuan</p>
                                    <p class="font-medium text-gray-800">{{ $student->level ?? 'LEVEL 1' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Total Pertemuan</p>
                                    <p class="font-medium text-gray-800 truncate">{{ $student->package_meetings ?? 8 }} Sesi</p>
                                </div>
                            </div>

                            @if(!empty($student->coach_notes))
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 mb-1">Catatan Coach</p>
                                <p class="text-sm text-gray-700 italic bg-white p-3 rounded border border-gray-100">"{{ $student->coach_notes }}"</p>
                            </div>
                            @endif

                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">Persentase Progres</span>
                                    <span class="font-medium text-gray-800">{{ $student->progress ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $student->progress ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Jadwal & Kehadiran -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-calendar-check text-emerald-500"></i>
                            <h3 class="font-semibold text-gray-800">Kehadiran</h3>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Program & Lokasi</p>
                                <p class="font-medium text-gray-800">{{ $student->program ?? '-' }}</p>
                                <p class="text-sm text-gray-600 mt-0.5"><i class="fa-solid fa-location-dot mr-1"></i> {{ $student->location ?? '-' }}</p>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">Catatan Kehadiran</span>
                                </div>
                                <div class="w-full flex gap-1 h-2">
                                    @php 
                                        $attArr = isset($student->attendance) ? (array)$student->attendance : [];
                                        $maxMeetings = isset($student->package_meetings) ? (int)$student->package_meetings : 8;
                                    @endphp
                                    @for($i = 0; $i < $maxMeetings; $i++)
                                        @php
                                            $attStatus = $attArr[$i] ?? 'Belum';
                                            $color = 'bg-gray-200';
                                            if($attStatus === 'Hadir') $color = 'bg-emerald-500';
                                            if($attStatus === 'Izin') $color = 'bg-amber-400';
                                            if($attStatus === 'Alpha') $color = 'bg-red-500';
                                        @endphp
                                        <div class="flex-1 rounded-sm {{ $color }}" title="Sesi {{ $i+1 }}: {{ $attStatus }}"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @else
        <div class="bg-white p-8 rounded-xl border border-gray-200 text-center text-gray-500 shadow-sm">
            <div class="text-4xl text-gray-300 mb-3"><i class="fa-solid fa-child-reaching"></i></div>
            <p>Belum ada data anak yang terdaftar pada akun Anda.</p>
        </div>
    @endif

    <!-- LEADERBOARD LAINNYA -->
    @if(isset($otherStudents) && $otherStudents->count() > 0)
        <div class="mt-10 mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-users text-blue-500"></i> Progres Siswa Lainnya
            </h2>
            <p class="text-gray-500 text-sm mt-1">Lihat dan bandingkan progres belajar siswa lainnya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($otherStudents as $other)
                <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $other->name }}</h3>
                                <p class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded inline-block mt-1">{{ $other->program }} - {{ current(explode('|', $other->level)) }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ $other->progress_percentage }}%
                            </div>
                        </div>

                        <div class="mb-3 text-xs text-gray-600 space-y-1">
                            <p><i class="fa-regular fa-clock w-4"></i> {{ $other->schedule }}</p>
                            <p><i class="fa-solid fa-person-swimming w-4"></i> {{ $other->package_meetings }} Sesi</p>
                        </div>

                        @if(!empty($other->coach_notes))
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 mb-1">Catatan Coach:</p>
                            <p class="text-xs text-gray-600 italic bg-slate-50 p-2 rounded border border-slate-100">"{{ Str::limit($other->coach_notes, 80) }}"</p>
                        </div>
                        @endif
                    </div>

                    <div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                            <div class="bg-gradient-to-r from-cyan-400 to-blue-500 h-1.5 rounded-full" style="width: {{ $other->progress_percentage }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


@else
    <!-- ADMIN / GENERAL DASHBOARD -->
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di ASSA Swimming</h1>
        <p class="text-gray-500 text-sm mt-1">Portal informasi kegiatan, jadwal perlombaan, dan pengelolaan data klub renang.</p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <!-- Widget 1: Total Siswa -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-0.5">Total Siswa</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalStudents ?? 0 }}</h3>
            </div>
        </div>

        <!-- Widget 2: Siswa Aktif -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-0.5">Siswa Aktif</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $activeStudents ?? 0 }}</h3>
            </div>
        </div>

        <!-- Widget 3: Total Program -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-0.5">Program Kelas</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalPrograms ?? 0 }}</h3>
            </div>
        </div>

        <!-- Widget 4: Total Coach -->
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-person-swimming"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-0.5">Total Coach</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalCoaches ?? 5 }}</h3>
            </div>
        </div>

    </div>

    @if(Auth::check() && (stripos(Auth::user()->name, 'Vicky') !== false || stripos(Auth::user()->name, 'Arin') !== false))
    <!-- Add Coach Form (Restricted to Vicky & Arin) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-2 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-cyan-600"></i> Tambah Akun Coach Baru
        </h3>
        <p class="text-sm text-slate-500 mb-4">Fitur ini khusus untuk Head Coach (Vicky & Arin). Gunakan untuk membuatkan akun bagi pelatih baru yang bergabung.</p>
        
        <form action="{{ route('coaches.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Nama Coach</label>
                <input type="text" name="name" required placeholder="Cth: Coach Budi" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Email (Gmail)</label>
                <input type="email" name="email" required placeholder="Cth: budi@gmail.com" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Password</label>
                <input type="password" name="password" required placeholder="Minimal 6 Karakter" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white font-bold rounded-lg shadow-sm transition">
                    <i class="fa-solid fa-plus mr-1"></i> Buat Akun
                </button>
            </div>
        </form>
        @error('email')
            <p class="text-xs text-red-500 mt-2"><i class="fa-solid fa-circle-exclamation"></i> Email tersebut sudah terdaftar.</p>
        @enderror
    </div>

    <!-- Coach List (Restricted to Vicky & Arin) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-users-gear text-cyan-600"></i> Daftar Akun Coach
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="pb-3 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Nama Coach</th>
                        <th class="pb-3 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Email</th>
                        <th class="pb-3 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coachesList as $coach)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3 px-2 border-b border-slate-100 text-sm font-medium text-slate-800">{{ $coach->name }}</td>
                        <td class="py-3 px-2 border-b border-slate-100 text-sm text-slate-600">{{ $coach->email }}</td>
                        <td class="py-3 px-2 border-b border-slate-100 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button type="button" onclick="openEditCoachModal('{{ $coach->id }}', '{{ addslashes($coach->name) }}', '{{ addslashes($coach->email) }}')" class="text-cyan-600 hover:text-cyan-800 text-sm font-semibold transition" title="Edit Akun">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>

                                @if($coach->id !== auth()->id())
                                    <form action="{{ route('coaches.destroy', $coach->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun coach ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-sm font-semibold transition" title="Hapus Akun">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic">Akun Anda</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Coach Modal -->
    <div id="editCoachModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-transform scale-95" id="editCoachModalContent">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800 text-lg">Edit Akun Coach</h3>
                <button type="button" onclick="closeEditCoachModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="editCoachForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Nama Coach</label>
                            <input type="text" id="edit-coach-name" name="name" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Email (Gmail)</label>
                            <input type="email" id="edit-coach-email" name="email" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Password Baru</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm py-2 px-3">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeEditCoachModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-lg transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-bold rounded-lg shadow-sm transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditCoachModal(id, name, email) {
            document.getElementById('edit-coach-name').value = name;
            document.getElementById('edit-coach-email').value = email;
            document.getElementById('editCoachForm').action = '/coaches/' + id;
            
            const modal = document.getElementById('editCoachModal');
            const content = document.getElementById('editCoachModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeEditCoachModal() {
            const modal = document.getElementById('editCoachModal');
            const content = document.getElementById('editCoachModalContent');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    </script>
    @endif

    <!-- Banner Section -->
    <div class="bg-gradient-to-r from-cyan-600 to-blue-700 rounded-2xl p-8 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl font-bold mb-2">Evaluasi Siswa Semakin Mudah</h2>
            <p class="text-cyan-100 max-w-2xl text-sm leading-relaxed">
                Gunakan menu Manajemen Siswa untuk melihat data lengkap, mengisi raport perkembangan (skills), mencatat kehadiran, serta memantau status pembayaran wali murid secara real-time.
            </p>
        </div>
        <div class="shrink-0">
            <a href="{{ route('students.index') }}" class="inline-block px-6 py-3 bg-white text-cyan-700 font-bold rounded-xl shadow hover:bg-cyan-50 transition">
                <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Kelola Data Siswa
            </a>
        </div>
    </div>

    @if(!Auth::check())
    <!-- Notice for Guest -->
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 flex items-start gap-4">
        <div class="mt-0.5 text-blue-500">
            <i class="fa-solid fa-circle-info text-xl"></i>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-blue-900">Akses Khusus Pelatih (Coach)</h4>
            <p class="text-sm text-blue-700 mt-1 mb-3">Untuk mengelola data siswa dan melakukan penilaian (raport), silakan login terlebih dahulu menggunakan akun Coach Anda.</p>
            <a href="{{ route('login') }}" class="text-sm font-medium text-blue-700 hover:text-blue-800 underline decoration-blue-300 underline-offset-4">
                Buka Halaman Login &rarr;
            </a>
        </div>
    </div>
    @endif
@endif

</div>

@endsection
