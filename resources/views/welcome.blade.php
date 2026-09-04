<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASSA Swimming</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/ASSAswim.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glassmorphism {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .animate-color-pulse {
            animation: colorPulse 4s infinite alternate;
        }

        @keyframes colorPulse {
            0% { background-color: #0284c7; box-shadow: 0 4px 14px 0 rgba(2, 132, 199, 0.39); }
            50% { background-color: #0ea5e9; box-shadow: 0 4px 14px 0 rgba(14, 165, 233, 0.39); }
            100% { background-color: #0369a1; box-shadow: 0 4px 14px 0 rgba(3, 105, 161, 0.39); }
        }

        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee-infinite {
            animation: marquee 25s linear infinite;
        }
        .marquee-container:hover .animate-marquee-infinite {
            animation-play-state: paused;
        }

        .char { display: inline-block; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glassmorphism transition-all duration-300 shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20" id="navbar-inner">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer" onclick="window.scrollTo({top:0, behavior:'smooth'})">
                    <img id="navbar-logo" src="{{ asset('images/ASSAswimremovebg.png') }}" alt="ASSA Swim Logo" class="h-16 w-auto object-contain" style="height: 64px;">
                    <span id="navbar-text" class="font-bold text-2xl tracking-tight text-slate-900">ASSA<span class="text-brand-600">Swimming</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">Fitur</a>
                    <a href="#coaches" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">Instruktur</a>
                    <a href="#gallery" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">Galeri</a>
                    <a href="#testimonials" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">Ulasan</a>
                    <div class="h-6 w-px bg-slate-200"></div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-brand-600 font-semibold hover:text-brand-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="text-slate-600 hover:text-slate-900 font-medium transition-colors">Daftar</a>
                        <a href="{{ route('login') }}" class="login-btn-pulse bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-full font-medium transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Login <i class="fa-solid fa-arrow-right ml-1 text-sm"></i>
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-600 hover:text-brand-600 focus:outline-none p-2" id="mobile-menu-btn">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div class="hidden md:hidden bg-white border-t border-slate-100 shadow-xl absolute w-full" id="mobile-menu">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#features" class="mobile-menu-item block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50">Fitur</a>
                <a href="#coaches" class="mobile-menu-item block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50">Instruktur</a>
                <a href="#gallery" class="mobile-menu-item block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50">Galeri</a>
                <a href="#testimonials" class="mobile-menu-item block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50">Ulasan</a>
                <div class="mobile-menu-item border-t border-slate-100 my-2"></div>
                @auth
                    <a href="{{ route('dashboard') }}" class="mobile-menu-item block px-3 py-3 rounded-md text-base font-bold text-brand-600 hover:bg-brand-50">Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="mobile-menu-item block px-3 py-3 rounded-md text-base font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50">Daftar Akun Baru</a>
                    <a href="{{ route('login') }}" class="mobile-menu-item block px-3 py-3 mt-2 text-center rounded-xl text-base font-medium bg-brand-600 text-white hover:bg-brand-700 shadow-md">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden min-h-[90vh] flex items-center">
        <!-- Background Decorations -->
        <div class="absolute top-0 -left-4 w-72 h-72 bg-brand-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-cyan-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <!-- Subtle Grid Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwgMCwgMCwgMC4wNSkiLz48L3N2Zz4=')] opacity-50 z-0"></div>

        <!-- Floating Decorative Bubbles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0" id="bubble-container">
            @for ($i = 0; $i < 15; $i++)
                <div class="floating-bubble absolute bottom-[-50px] opacity-40" style="left: {{ rand(5, 95) }}%; width: {{ rand(10, 40) }}px; height: {{ rand(10, 40) }}px; border-radius: 50%; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.8), rgba(255,255,255,0.1) 60%, rgba(2, 132, 199, 0.2)); border: 1px solid rgba(255,255,255,0.5);"></div>
            @endfor
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">

                <!-- Text Content -->
                <div class="lg:col-span-6 text-center lg:text-left mb-16 lg:mb-0">
                    <div class="hero-stagger-item inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-50 border border-brand-100 text-brand-700 font-medium text-sm mb-6 shadow-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        Sistem Manajemen Les Renang Modern
                    </div>

                    <div class="hero-stagger-item overflow-hidden">
                        <h1 class="split-reveal-text text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.15] mb-6 tracking-tight">
                            Wujudkan Kemampuan <br/>
                            Renangmu Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-cyan-500">ASSA</span>
                        </h1>
                    </div>

                    <p class="hero-stagger-item text-lg text-slate-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Pantau jadwal latihan, evaluasi perkembangan anak dengan sistem raport digital kami, dan jadilah perenang profesional bersama pelatih ahli kami.
                    </p>

                    <div class="hero-stagger-item flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all shadow-lg shadow-brand-500/30 transform hover:-translate-y-1 flex items-center justify-center gap-2 animate-color-pulse">
                                <i class="fa-solid fa-gauge-high"></i> Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all shadow-lg shadow-brand-500/30 transform hover:-translate-y-1 flex items-center justify-center gap-2 animate-color-pulse">
                                Daftar Sekarang <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <a href="{{ route('login') }}" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-8 py-4 rounded-xl font-semibold text-lg transition-all shadow-sm flex items-center justify-center gap-2">
                                Login Akun
                            </a>
                        @endauth
                    </div>

                    <div class="hero-stagger-item mt-10 flex items-center justify-center lg:justify-start gap-6 text-sm text-slate-500 font-medium">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-lg"></i> Raport Digital
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-lg"></i> Jadwal Fleksibel
                        </div>
                    </div>
                </div>

                <!-- Graphic / Image -->
                <div class="lg:col-span-6 relative hero-stagger-item">
                    <!-- Main Card mockup -->
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-slate-100 bg-white transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <!-- Mac OS style top bar -->
                        <div class="bg-slate-100 px-4 py-3 flex items-center gap-2 border-b border-slate-200">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>

                        <!-- Content inside mockup -->
                        <div class="p-6 bg-slate-50">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="font-bold text-lg text-slate-800">Raport Siswa</h3>
                                    <p class="text-sm text-slate-500">Bulan Ini</p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xl">
                                    A
                                </div>
                            </div>

                            <!-- Skill bars -->
                            <div class="space-y-4 mb-6">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-slate-700">Teknik Pernafasan</span>
                                        <span class="text-brand-600 font-bold">90%</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-brand-500 h-2 rounded-full" style="width: 90%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-slate-700">Gaya Bebas</span>
                                        <span class="text-brand-600 font-bold">85%</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-cyan-500 h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-slate-700">Gaya Dada</span>
                                        <span class="text-brand-600 font-bold">75%</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                        <div class="bg-blue-400 h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-brand-50 p-4 rounded-xl border border-brand-100 flex items-start gap-3">
                                <i class="fa-solid fa-medal text-amber-500 text-xl mt-1"></i>
                                <div>
                                    <h4 class="font-semibold text-brand-800 text-sm">Pencapaian Sangat Baik!</h4>
                                    <p class="text-xs text-brand-600 mt-1">Perkembangan luar biasa dibanding minggu lalu. Teruskan berlatih!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Siswa Terdaftar</p>
                            <p class="font-bold text-slate-800 text-xl" id="student-counter">0+</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-2">Mengapa Memilih Kami</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Solusi Terbaik Untuk Pembelajaran Renang</h3>
                <p class="text-slate-600 text-lg">Platform ASSA dirancang khusus untuk memudahkan interaksi antara pelatih, manajemen, dan peserta les.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:border-brand-100 transition-all group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-brand-600 text-2xl mb-6 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Jadwal Teratur</h4>
                    <p class="text-slate-600 leading-relaxed">Manajemen jadwal yang rapi memastikan anak Anda selalu mendapatkan waktu latihan yang optimal tanpa bentrok.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:border-brand-100 transition-all group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-brand-600 text-2xl mb-6 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Raport Digital</h4>
                    <p class="text-slate-600 leading-relaxed">Pantau perkembangan setiap indikator secara transparan melalui dashboard online yang bisa diakses kapan saja.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-xl hover:border-brand-100 transition-all group">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-brand-600 text-2xl mb-6 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-3">Pelatih Tersertifikasi</h4>
                    <p class="text-slate-600 leading-relaxed">Dilatih oleh tenaga profesional yang sudah teruji, menjamin keamanan dan efektivitas metode pembelajaran.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Awards Section -->
    <section class="py-12 bg-slate-900 border-t border-slate-800 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-slate-400 uppercase tracking-widest mb-8">Prestasi & Kebanggaan Kami</p>
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                <!-- Award 1 -->
                <div class="flex flex-col items-center justify-center text-white text-center w-32 relative">
                    <i class="fa-solid fa-sparkles text-amber-300 text-xl absolute -top-4 -right-2 sparkle-icon"></i>
                    <i class="fa-solid fa-award text-4xl mb-2 text-amber-400 relative z-10"></i>
                    <span class="text-xs font-bold leading-tight">Sekolah Renang Terbaik</span>
                </div>
                <!-- Award 2 -->
                <div class="flex flex-col items-center justify-center text-white text-center w-32 relative">
                    <i class="fa-solid fa-sparkles text-cyan-300 text-xl absolute -top-4 -left-2 sparkle-icon"></i>
                    <i class="fa-solid fa-medal text-4xl mb-2 text-brand-400 relative z-10"></i>
                    <span class="text-xs font-bold leading-tight">Standar Keamanan Terjamin</span>
                </div>
                <!-- Award 3 -->
                <div class="flex flex-col items-center justify-center text-white text-center w-32 relative">
                    <i class="fa-solid fa-sparkles text-emerald-300 text-xl absolute top-0 -right-4 sparkle-icon"></i>
                    <i class="fa-solid fa-shield-halved text-4xl mb-2 text-emerald-400 relative z-10"></i>
                    <span class="text-xs font-bold leading-tight">Instruktur Bersertifikat</span>
                </div>
                <!-- Award 4 -->
                <div class="flex flex-col items-center justify-center text-white text-center w-32 relative">
                    <i class="fa-solid fa-sparkles text-rose-300 text-xl absolute -top-4 right-0 sparkle-icon"></i>
                    <i class="fa-solid fa-trophy text-4xl mb-2 text-rose-400 relative z-10"></i>
                    <span class="text-xs font-bold leading-tight">Langganan Juara Lomba</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Coach Profile Section -->
    <section id="coaches" class="py-20 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-2">Instruktur Kami</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Belajar Bersama Pelatih Profesional</h3>
                <p class="text-slate-600 text-lg">Semua pelatih kami telah bersertifikat dan berpengalaman menangani berbagai kelompok usia dan karakter siswa.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Coach 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                    <div class="h-64 bg-slate-200 relative overflow-hidden coach-portrait-container">
                        <img src="images/coachvicky.png" alt="Coach Budi" class="absolute top-[-20px] left-0 w-full h-[calc(100%+40px)] object-cover coach-portrait">
                        <div class="absolute inset-0 bg-brand-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <div class="p-6 text-center relative">
                        <div class="absolute -top-6 right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md text-brand-500 text-xl border-4 border-white z-10">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-1 split-name">Coach Vicky</h4>
                        <p class="text-brand-600 font-medium text-sm mb-4">spesialis anak & dewasa</p>
                        <p class="text-slate-600 text-sm">Spesialis anak advance dan special needs dengan pendekatan latihan yang sesuai.</p>
                    </div>
                </div>

                <!-- Coach 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                    <div class="h-64 bg-slate-200 relative overflow-hidden coach-portrait-container">
                        <img src="images/coacharin.png" alt="Coach Sarah" class="absolute top-[-20px] left-0 w-full h-[calc(100%+40px)] object-cover coach-portrait">
                        <div class="absolute inset-0 bg-cyan-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <div class="p-6 text-center relative">
                        <div class="absolute -top-6 right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md text-cyan-500 text-xl border-4 border-white z-10">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-1 split-name">Coach Arin</h4>
                        <p class="text-brand-600 font-medium text-sm mb-4">spesialis anak & dewasa</p>
                        <p class="text-slate-600 text-sm">Berpengalaman mengajar anak-anak dan dewasa dengan metode yang menyenangkan.</p>
                    </div>
                </div>

                <!-- Coach 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                    <div class="h-64 bg-slate-200 relative overflow-hidden coach-portrait-container">
                        <img src="images/coachtasya.png" alt="Coach Tasya" class="absolute top-[-20px] left-0 w-full h-[calc(100%+40px)] object-cover coach-portrait">
                        <div class="absolute inset-0 bg-blue-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <div class="p-6 text-center relative">
                        <div class="absolute -top-6 right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md text-blue-500 text-xl border-4 border-white z-10">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-1 split-name">Coach Tasya</h4>
                        <p class="text-brand-600 font-medium text-sm mb-4">spesialis anak & dewasa</p>
                        <p class="text-slate-600 text-sm">Mendampingi pemula membangun kepercayaan diri dan kemampuan dasar berenang.</p>
                    </div>
                </div>

                 <!-- Coach 4 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                    <div class="h-64 bg-slate-200 relative overflow-hidden coach-portrait-container">
                        <img src="images/coachtiwi.png" alt="Coach Tiwi" class="absolute top-[-20px] left-0 w-full h-[calc(100%+40px)] object-cover coach-portrait">
                        <div class="absolute inset-0 bg-cyan-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
                    </div>
                    <div class="p-6 text-center relative">
                        <div class="absolute -top-6 right-6 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md text-cyan-500 text-xl border-4 border-white z-10">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 mb-1 split-name">Coach Tiwi</h4>
                        <p class="text-brand-600 font-medium text-sm mb-4">spesialis anak & dewasa</p>
                        <p class="text-slate-600 text-sm">Membantu siswa meningkatkan teknik dan kemampuan renang yang sudah dimiliki.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-2">Galeri Kami</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Momen Keceriaan di Kolam Renang</h3>
                <p class="text-slate-600 text-lg">Intip suasana belajar yang menyenangkan, aman, dan bersih bersama pelatih-pelatih ASSA Swimming.</p>
            </div>

            <div class="flex flex-col gap-12 md:gap-20 gallery-parallax-container py-10 max-w-5xl mx-auto w-full">
                <!-- Gallery Item 1 -->
                <div class="gallery-item group sticky top-24 md:top-32 aspect-video rounded-3xl overflow-hidden bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-brand-500/10 group-hover:bg-brand-900/40 transition-colors duration-300 z-10"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                        <i class="fa-solid fa-magnifying-glass-plus text-white text-5xl"></i>
                    </div>
                    <div class="w-full h-full group-hover:scale-105 transition-transform duration-700 flex items-center justify-center">
                        <img src="images/galeri1.png" alt="Gallery" class="w-full h-full object-contain">
                    </div>
                    <!-- Overlay for dimming effect when scrolling -->
                    <div class="dim-overlay absolute inset-0 bg-black opacity-0 z-30 pointer-events-none"></div>
                </div>

                <!-- Gallery Item 2 -->
                <div class="gallery-item group sticky top-28 md:top-40 aspect-video rounded-3xl overflow-hidden bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-cyan-500/10 group-hover:bg-cyan-900/40 transition-colors duration-300 z-10"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                        <i class="fa-solid fa-magnifying-glass-plus text-white text-5xl"></i>
                    </div>
                    <div class="w-full h-full group-hover:scale-105 transition-transform duration-700 relative overflow-hidden flex items-center justify-center">
                        <img src="images/galeri3.png" alt="Gallery" class="w-full h-full object-contain">
                        <span class="absolute bottom-8 left-8 text-white font-bold text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-30 drop-shadow-lg">Kelas Balita</span>
                    </div>
                    <div class="dim-overlay absolute inset-0 bg-black opacity-0 z-30 pointer-events-none"></div>
                </div>

                <!-- Gallery Item 3 -->
                <div class="gallery-item group sticky top-32 md:top-48 aspect-video rounded-3xl overflow-hidden bg-slate-900 shadow-2xl">
                    <div class="absolute inset-0 bg-blue-500/10 group-hover:bg-blue-900/40 transition-colors duration-300 z-10"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                        <i class="fa-solid fa-magnifying-glass-plus text-white text-5xl"></i>
                    </div>
                    <div class="w-full h-full group-hover:scale-105 transition-transform duration-700 flex items-center justify-center">
                        <img src="images/galeri2.jpeg" alt="Gallery" class="w-full h-full object-contain">
                    </div>
                    <div class="dim-overlay absolute inset-0 bg-black opacity-0 z-30 pointer-events-none"></div>
                </div>
            </div>


        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-brand-600 text-white relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full border-8 border-brand-500 opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-500 opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-200 font-semibold tracking-wide uppercase text-sm mb-2">Ulasan Siswa</h2>
                <h3 class="text-3xl md:text-4xl font-bold mb-4">Apa Kata Mereka Tentang ASSA?</h3>
            </div>

            <div class="overflow-hidden">
                <div class="testimonial-carousel flex gap-6 w-max pb-8 px-4">
                    <!-- Testimonial 1 -->
                    <div class="testi-card w-[85vw] md:w-[450px] bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 relative flex-shrink-0">
                        <div class="text-amber-400 flex gap-1 mb-4 text-sm">
                            <i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i>
                        </div>
                        <p class="testi-text text-brand-50 italic mb-6 text-lg leading-relaxed">"Fitur raportnya juara! Saya sebagai orang tua jadi tahu persis perkembangan anak. Dan pelatihnya sangat sabar menghadapi anak saya yang tadinya takut air."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="testi-avatar w-12 h-12 bg-white text-brand-600 rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                                M
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Bunda Maya</h4>
                                <p class="text-brand-200 text-sm">Orang tua siswa (Kelas Anak)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="testi-card w-[85vw] md:w-[450px] bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 relative flex-shrink-0">
                        <div class="text-amber-400 flex gap-1 mb-4 text-sm">
                            <i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i>
                        </div>
                        <p class="testi-text text-brand-50 italic mb-6 text-lg leading-relaxed">"Baru belajar renang di usia 25 tahun ternyata tidak memalukan. Coach Anton sangat profesional dan bikin percaya diri. Dalam 4x pertemuan sudah bisa gaya dada santai."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="testi-avatar w-12 h-12 bg-white text-brand-600 rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                                R
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Reza Pratama</h4>
                                <p class="text-brand-200 text-sm">Siswa (Kelas Dewasa)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="testi-card w-[85vw] md:w-[450px] bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 relative flex-shrink-0">
                        <div class="text-amber-400 flex gap-1 mb-4 text-sm">
                            <i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i>
                        </div>
                        <p class="testi-text text-brand-50 italic mb-6 text-lg leading-relaxed">"Sistem penjadwalannya sangat fleksibel. Kalau anak tiba-tiba sakit, admin dengan sigap membantu reschedule tanpa biaya tambahan. Pokoknya recommended!"</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="testi-avatar w-12 h-12 bg-white text-brand-600 rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                                D
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Papa Dimas</h4>
                                <p class="text-brand-200 text-sm">Orang tua siswa (Kelas Balita)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="testi-card w-[85vw] md:w-[450px] bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 relative flex-shrink-0">
                        <div class="text-amber-400 flex gap-1 mb-4 text-sm">
                            <i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i>
                        </div>
                        <p class="testi-text text-brand-50 italic mb-6 text-lg leading-relaxed">"Kolam selalu bersih dan penjagaan sangat ketat. Saya bisa tenang meninggalkan anak latihan karena keamanannya terjamin."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="testi-avatar w-12 h-12 bg-white text-brand-600 rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                                S
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Siti Aisyah</h4>
                                <p class="text-brand-200 text-sm">Orang tua siswa (Kelas Anak)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 5 -->
                    <div class="testi-card w-[85vw] md:w-[450px] bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 relative flex-shrink-0">
                        <div class="text-amber-400 flex gap-1 mb-4 text-sm">
                            <i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i><i class="fa-solid fa-star testi-star"></i>
                        </div>
                        <p class="testi-text text-brand-50 italic mb-6 text-lg leading-relaxed">"Fasilitas ruang bilas air hangat sangat membantu terutama untuk anak-anak sehabis latihan sore. Sistem ASSA sangat modern."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="testi-avatar w-12 h-12 bg-white text-brand-600 rounded-full flex items-center justify-center font-bold text-lg shadow-sm">
                                B
                            </div>
                            <div>
                                <h4 class="font-bold text-white">Bapak Hendra</h4>
                                <p class="text-brand-200 text-sm">Member VIP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer-ripple-area" class="bg-slate-900 text-slate-300 py-16 border-t border-slate-800 relative overflow-hidden cursor-pointer">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pointer-events-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Column 1: Brand -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white p-1.5 rounded-xl shadow-sm">
                            <img src="{{ asset('images/ASSAswim.png') }}" alt="ASSA Swim Logo" class="h-9 w-auto object-contain">
                        </div>
                        <span class="font-bold text-2xl text-white tracking-tight">ASSA<span class="text-brand-400">Swim</span></span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Klub renang terkemuka dengan kurikulum terstruktur dan pelatih profesional untuk membentuk generasi perenang tangguh, disiplin, dan berprestasi.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.instagram.com/assaswimmingschoolacademy" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-500 hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-brand-500/25">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="https://www.tiktok.com/@assaswimmingcourse?_r=1&_t=ZS-99DnQuzP8n2" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-500 hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-brand-500/25">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </a>
                        <a href="https://wa.me/6285126220060" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-emerald-500 hover:text-white transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-emerald-500/25">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-400"></span> Navigasi
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="#about" class="text-slate-400 hover:text-brand-400 hover:pl-2 transition-all duration-300 text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Tentang Kami</a></li>
                        <li><a href="#levels" class="text-slate-400 hover:text-brand-400 hover:pl-2 transition-all duration-300 text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Kurikulum & Level</a></li>
                        <li><a href="#facilities" class="text-slate-400 hover:text-brand-400 hover:pl-2 transition-all duration-300 text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Fasilitas Kolam</a></li>
                        <li><a href="#coaches" class="text-slate-400 hover:text-brand-400 hover:pl-2 transition-all duration-300 text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Profil Coach</a></li>
                        <li><a href="#gallery" class="text-slate-400 hover:text-brand-400 hover:pl-2 transition-all duration-300 text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs"></i> Galeri Kegiatan</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact Info -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span> Kontak Kami
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-slate-400 text-sm">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center flex-shrink-0 text-cyan-400">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <span class="pt-1.5">Griya persada asri MA/08 Rt 16 Rw 06 sidodadi candi sidoarjo</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-400 text-sm">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center flex-shrink-0 text-cyan-400">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span class="pt-1.5">+62 851-2622-0060</span>
                        </li>
                        <li class="flex items-start gap-3 text-slate-400 text-sm">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center flex-shrink-0 text-cyan-400">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <span class="pt-1.5">hello@assaswiming.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Operational Hours -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-400"></span> Jam Operasional
                    </h3>
                    <div class="bg-slate-800/50 rounded-xl p-5 border border-slate-700">
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li class="flex justify-between items-center pb-2 border-b border-slate-700/50">
                                <span>Senin - Minggu</span>
                                <span class="font-medium text-white">06.00 - 21.00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
                <p class="text-slate-500 mb-4 md:mb-0">&copy; <span id="copyright-year">1990</span> ASSA Swimming Course. All rights reserved.</p>
                <div class="flex space-x-6 text-slate-500">
                    <a href="#" class="hover:text-brand-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-400 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-brand-400 transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            gsap.registerPlugin(ScrollTrigger);

            // 1. Staggered Page Load (Hero Section)
            gsap.from(".hero-stagger-item", {
                y: 40,
                opacity: 0,
                duration: 1,
                stagger: 0.15,
                ease: "power3.out",
                delay: 0.1
            });

            // 2. Text SplitReveal (Simple approach: split words with spans and animate)
            const splitText = document.querySelector('.split-reveal-text');
            if (splitText) {
                // To keep it simple without paid SplitText plugin, we use the stagger above
                // which reveals the entire text block beautifully.
            }

            // 3. Statistic Counter Spin
            const counter = document.getElementById("student-counter");
            if (counter) {
                let obj = { val: 0 };
                gsap.to(obj, {
                    val: 200,
                    duration: 3,
                    ease: "power2.out",
                    delay: 1.2,
                    onUpdate: function() {
                        counter.innerHTML = Math.floor(obj.val) + "+";
                    }
                });
            }

            // 4. Floating Decorative Bubbles
            const bubbles = document.querySelectorAll('.floating-bubble');
            bubbles.forEach((bubble) => {
                gsap.to(bubble, {
                    y: -window.innerHeight - 100,
                    x: "+=" + (Math.random() * 100 - 50),
                    duration: Math.random() * 15 + 10,
                    repeat: -1,
                    ease: "none",
                    delay: Math.random() * 10
                });
            });

            // 5. Sparkle Rotation
            gsap.to(".sparkle-icon", {
                rotation: 360,
                duration: 4,
                repeat: -1,
                ease: "none"
            });

            // 6. Parallax Portrait (Coaches)
            gsap.utils.toArray('.coach-portrait').forEach(img => {
                gsap.to(img, {
                    y: 40,
                    ease: "none",
                    scrollTrigger: {
                        trigger: img.parentElement,
                        start: "top bottom",
                        end: "bottom top",
                        scrub: true
                    }
                });
            });

            // 7. Name Text Reveal
            gsap.utils.toArray('.split-name').forEach(name => {
                // simple char split manually
                const text = name.innerText;
                name.innerHTML = text.split('').map(char => `<span class="char">${char === ' ' ? '&nbsp;' : char}</span>`).join('');

                gsap.from(name.querySelectorAll('.char'), {
                    y: 20,
                    opacity: 0,
                    duration: 0.5,
                    stagger: 0.05,
                    ease: "back.out(1.7)",
                    scrollTrigger: {
                        trigger: name,
                        start: "top 90%",
                    }
                });
            });

            // 8. Gallery Scroll Reveal & Parallax
            const galleryContainer = document.querySelector('.gallery-parallax-container');
            if (galleryContainer) {
                // Reveal animation
                gsap.from('.gallery-item', {
                    scrollTrigger: {
                        trigger: "#gallery",
                        start: "top 80%",
                    },
                    y: 60,
                    opacity: 0,
                    scale: 0.95,
                    duration: 0.8,
                    stagger: 0.15,
                    ease: "power2.out"
                });

                // Vertical Parallax effect based on scroll for inner images
                if (window.innerWidth > 768) {
                    gsap.utils.toArray('.parallax-img').forEach(img => {
                        gsap.to(img, {
                            y: "10%",
                            ease: "power1.out",
                            scrollTrigger: {
                                trigger: img.closest('.gallery-item'),
                                start: "top bottom",
                                end: "bottom top",
                                scrub: 1.5
                            }
                        });
                    });

                    // Smooth Stacking Cards scale-down effect
                    const cards = gsap.utils.toArray('.gallery-item');
                    cards.forEach((card, index) => {
                        if (index !== cards.length - 1) { // Skip the last card
                            // Scale down the card
                            gsap.to(card, {
                                scale: 0.93, // Subtler scale down
                                ease: "none",
                                scrollTrigger: {
                                    trigger: card,
                                    start: "top 128px",
                                    end: "+=120%",
                                    scrub: true
                                }
                            });

                            // Fade in the dark overlay
                            const overlay = card.querySelector('.dim-overlay');
                            if (overlay) {
                                gsap.to(overlay, {
                                    opacity: 0.25, // Only 25% black (very light dimming)
                                    ease: "none",
                                    scrollTrigger: {
                                        trigger: card,
                                        start: "top 128px",
                                        end: "+=120%",
                                        scrub: true
                                    }
                                });
                            }
                        }
                    });
                }
            }


            // 10. Infinite Carousel Testimonials & Simplified Text Reveal
            const testiSection = document.getElementById("testimonials");
            const testiCarousel = document.querySelector(".testimonial-carousel");

            if (testiSection && testiCarousel) {
                // Remove scroll pinning and create an infinite moving loop (marquee)
                // First, calculate the original width and gap
                const originalWidth = testiCarousel.scrollWidth;
                const gap = 24; // gap-6 in Tailwind is 24px

                // Duplicate the content to create a seamless loop
                testiCarousel.innerHTML += testiCarousel.innerHTML;

                // Animate continuously to the left
                gsap.to(testiCarousel, {
                    x: -(originalWidth + gap),
                    duration: 30, // Speed of the marquee
                    ease: "none",
                    repeat: -1
                });

                // Set up for interior animations (triggered when section comes into view)
                // We use the new children list since we just duplicated them
                gsap.utils.toArray(testiCarousel.children).forEach((card, i) => {
                    // 11. Stars Pop
                    gsap.from(card.querySelectorAll('.testi-star'), {
                        scale: 0,
                        opacity: 0,
                        duration: 0.6,
                        stagger: 0.05,
                        ease: "back.out(1.5)",
                        scrollTrigger: {
                            trigger: testiSection,
                            start: "top 75%",
                        },
                        delay: (i % 5) * 0.1 // Use modulo 5 since we duplicated 5 cards
                    });

                    // 12. Text Reveal (No more word-splitting to prevent cut-off fonts!)
                    const textP = card.querySelector('.testi-text');
                    if(textP) {
                        gsap.from(textP, {
                            opacity: 0,
                            y: 20,
                            duration: 0.8,
                            scrollTrigger: {
                                trigger: testiSection,
                                start: "top 75%",
                            },
                            delay: ((i % 5) * 0.1) + 0.2
                        });
                    }
                });

                // 13. Avatar Spin
                gsap.to('.testi-avatar', {
                    rotation: 360,
                    duration: 10,
                    repeat: -1,
                    ease: "none"
                });
            }

            // 14. Copyright Year Counter
            const yearElem = document.getElementById("copyright-year");
            if (yearElem) {
                let yearObj = { val: 1990 };
                gsap.to(yearObj, {
                    val: {{ date('Y') }},
                    duration: 2,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: yearElem,
                        start: "top 95%"
                    },
                    onUpdate: () => { yearElem.innerHTML = Math.floor(yearObj.val); }
                });
            }

            // 15. Social Media Icons Jump
            document.querySelectorAll('.social-icon').forEach(icon => {
                icon.addEventListener('mouseenter', () => {
                    gsap.to(icon.querySelector('i'), {
                        y: -8,
                        duration: 0.25,
                        yoyo: true,
                        repeat: 1,
                        ease: "power1.inOut"
                    });
                });
            });

            // 16. Ripple Click Effect on Footer
            const footer = document.getElementById("footer-ripple-area");
            if (footer) {
                footer.addEventListener("click", function(e) {
                    // Prevent ripple if clicking a link directly
                    if(e.target.closest('a')) return;

                    let rect = footer.getBoundingClientRect();
                    let x = e.clientX - rect.left;
                    let y = e.clientY - rect.top;

                    let ripple = document.createElement("div");
                    ripple.className = "absolute rounded-full bg-brand-500/20 pointer-events-none";
                    ripple.style.left = x + "px";
                    ripple.style.top = y + "px";
                    ripple.style.width = "0px";
                    ripple.style.height = "0px";
                    ripple.style.transform = "translate(-50%, -50%)";
                    footer.appendChild(ripple);

                    gsap.to(ripple, {
                        width: 1500,
                        height: 1500,
                        opacity: 0,
                        duration: 1.5,
                        ease: "power2.out",
                        onComplete: () => ripple.remove()
                    });
                });
            }
            // 17. Login Button Pulse
            const loginBtn = document.querySelector('.login-btn-pulse');
            if (loginBtn) {
                gsap.to(loginBtn, {
                    scale: 1.05,
                    boxShadow: "0px 0px 15px rgba(3, 105, 161, 0.4)",
                    duration: 0.8,
                    yoyo: true,
                    repeat: -1,
                    ease: "sine.inOut"
                });
            }
        });


        // Navbar Scrolled State & Navbar Shrink (GSAP 18)
        const navbar = document.getElementById('navbar');
        const navbarInner = document.getElementById('navbar-inner');
        const navbarLogo = document.getElementById('navbar-logo');
        const navbarText = document.getElementById('navbar-text');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('bg-white/90', 'shadow-md');
                navbar.classList.remove('glassmorphism');
                gsap.to(navbarInner, { height: 64, duration: 0.3, ease: "power2.out" }); // Shrink to h-16 equivalent
                if(navbarLogo) gsap.to(navbarLogo, { height: 48, duration: 0.3, ease: "power2.out" });
                if(navbarText) gsap.to(navbarText, { scale: 0.85, transformOrigin: "left center", duration: 0.3, ease: "power2.out" });
            } else {
                navbar.classList.remove('bg-white/90', 'shadow-md');
                navbar.classList.add('glassmorphism');
                gsap.to(navbarInner, { height: 80, duration: 0.3, ease: "power2.out" }); // Back to h-20 equivalent
                if(navbarLogo) gsap.to(navbarLogo, { height: 64, duration: 0.3, ease: "power2.out" });
                if(navbarText) gsap.to(navbarText, { scale: 1, transformOrigin: "left center", duration: 0.3, ease: "power2.out" });
            }
        });

        // Mobile Menu Toggle & Menu Item Stagger (GSAP 19)
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            if (!menu.classList.contains('hidden')) {
                gsap.fromTo('.mobile-menu-item',
                    { x: -30, opacity: 0 },
                    { x: 0, opacity: 1, duration: 0.4, stagger: 0.08, ease: "back.out(1.5)" }
                );
            }
        });
    </script>
</body>
</html>
