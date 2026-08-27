@extends('layouts.guest')
@section('title', 'Pendaftaran Siswa Baru - ASSA Swimming')

@section('content')
<div class="w-full animate-fade-in-up" style="animation: fadeInUp 0.5s ease-out forwards;">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-cyan-600 mb-6 transition-colors font-medium">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Pendaftaran Siswa</h2>
        <p class="text-slate-500 mt-2">Isi formulir di bawah ini untuk bergabung menjadi bagian dari ASSA Swimming.</p>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded mb-6 text-sm flex items-start">
            <i class="fa-solid fa-circle-exclamation mt-0.5 mr-3"></i>
            <div>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6 text-sm flex items-center font-medium">
            <i class="fa-solid fa-check-circle mr-3 text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-user text-slate-400"></i>
                </div>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <div>
            <label for="nickname" class="block text-sm font-medium text-slate-700 mb-1">Nama Panggilan</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-id-badge text-slate-400"></i>
                </div>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}" required
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="age" class="block text-sm font-medium text-slate-700 mb-1">Umur</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-calendar-day text-slate-400"></i>
                    </div>
                    <input type="number" id="age" name="age" value="{{ old('age') }}" required min="1"
                           class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-brands fa-whatsapp text-slate-400"></i>
                    </div>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
                </div>
            </div>
        </div>

        <div>
            <label for="parent_name" class="block text-sm font-medium text-slate-700 mb-1">Nama Orang Tua</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-user-group text-slate-400"></i>
                </div>
                <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap</label>
            <div class="relative">
                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                    <i class="fa-solid fa-location-dot text-slate-400"></i>
                </div>
                <textarea id="address" name="address" required rows="2"
                          class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">{{ old('address') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="program" class="block text-sm font-medium text-slate-700 mb-1">Program</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-person-swimming text-slate-400"></i>
                    </div>
                    <select id="program" name="program" required
                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white appearance-none">
                        <option value="" disabled selected>Pilih Program</option>
                        <option value="Private" {{ old('program') == 'Private' ? 'selected' : '' }}>Private</option>
                        <option value="Semi Private" {{ old('program') == 'Semi Private' ? 'selected' : '' }}>Semi Private</option>
                        <option value="Reguler / Kelompok" {{ old('program') == 'Reguler / Kelompok' ? 'selected' : '' }}>Reguler / Kelompok</option>
                        <option value="Trial" {{ old('program') == 'Trial' ? 'selected' : '' }}>Trial</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="nominal" class="block text-sm font-medium text-slate-700 mb-1">Nominal Pembayaran</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-money-bill-wave text-slate-400"></i>
                    </div>
                    <input type="number" id="nominal" name="nominal" value="{{ old('nominal') }}" required min="0" placeholder="Contoh: 350000"
                           class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
                </div>
            </div>
        </div>

        <div>
            <label for="location" class="block text-sm font-medium text-slate-700 mb-1">Tempat Renang</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-water text-slate-400"></i>
                </div>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="schedule_day" class="block text-sm font-medium text-slate-700 mb-1">Hari Latihan Tetap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                    </div>
                    <select id="schedule_day" name="schedule_day" required
                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white appearance-none">
                        <option value="" disabled selected>Pilih Hari</option>
                        <option value="Senin" {{ old('schedule_day') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('schedule_day') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('schedule_day') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('schedule_day') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('schedule_day') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ old('schedule_day') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ old('schedule_day') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="schedule_time" class="block text-sm font-medium text-slate-700 mb-1">Jam Latihan Tetap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-clock text-slate-400"></i>
                    </div>
                    <input type="time" id="schedule_time" name="schedule_time" value="{{ old('schedule_time') }}" required
                           class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
                </div>
            </div>
        </div>

        <div>
            <label for="source" class="block text-sm font-medium text-slate-700 mb-1">Tau dari mana program ini?</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-bullhorn text-slate-400"></i>
                </div>
                <select id="source" name="source" required
                        class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white appearance-none">
                    <option value="" disabled selected>Pilih Sumber Informasi</option>
                    <option value="TikTok" {{ old('source') == 'TikTok' ? 'selected' : '' }}>TikTok</option>
                    <option value="Instagram" {{ old('source') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="Threads" {{ old('source') == 'Threads' ? 'selected' : '' }}>Threads</option>
                    <option value="Poster" {{ old('source') == 'Poster' ? 'selected' : '' }}>Poster</option>
                    <option value="Teman" {{ old('source') == 'Teman' ? 'selected' : '' }}>Teman</option>
                </select>
            </div>
        </div>

        <hr class="border-slate-200 my-4">

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email (Untuk Login)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-slate-400"></i>
                </div>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-400"></i>
                </div>
                <input type="password" id="password" name="password" required minlength="8"
                       class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-all bg-slate-50 focus:bg-white">
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 mt-2">
            Kirim Pendaftaran
        </button>
        
        <div class="text-center mt-6 text-sm text-slate-600">
            Sudah mendaftar dan punya akun? <a href="{{ route('login') }}" class="text-cyan-600 hover:text-cyan-700 font-semibold hover:underline">Login di sini</a>
        </div>
    </form>
</div>
@endsection
