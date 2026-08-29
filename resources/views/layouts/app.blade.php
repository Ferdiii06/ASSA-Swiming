<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ASSA Swimming')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <!-- Backdrop Overlay for Mobile Sidebar -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/60 z-20 hidden md:hidden transition-opacity"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed md:sticky top-0 left-0 z-30 h-screen w-64 bg-slate-900 text-white flex flex-col shrink-0 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-5 border-b border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/ASSAswim.png') }}" alt="ASSA Swimming Logo" class="h-8 bg-white rounded-md p-1">
                    <span class="text-lg font-bold">ASSA Swimming</span>
                </div>
                <!-- Close Button on Mobile -->
                <button id="close-sidebar-btn" class="md:hidden text-slate-400 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-cyan-600' : '' }}">
                    <i class="fa-solid fa-gauge w-5"></i> Dashboard
                </a>
                @if(!auth()->check() || !auth()->user()->isParent())
                <a href="{{ route('students.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 {{ request()->routeIs('students.*') ? 'bg-cyan-600' : '' }}">
                    <i class="fa-solid fa-graduation-cap w-5"></i> Siswa
                </a>
                
                <div class="pt-4 mt-2 border-t border-slate-700"></div>
                @endif
                
                @auth


                <div class="pt-4 mt-2 border-t border-slate-700"></div>
                <form method="POST" action="{{ route('logout') }}" class="block w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-rose-900/50 text-rose-400 transition text-left">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Logout
                    </button>
                </form>

                @endauth
            </nav>
            <div class="p-4 border-t border-slate-700 text-xs text-slate-400">
                &copy; {{ date('Y') }} Swim les
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white shadow-sm px-4 sm:px-6 py-3.5 flex justify-between items-center sticky top-0 z-40 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <!-- Hamburger Button Mobile -->
                    <button id="open-sidebar-btn" class="md:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg focus:outline-none hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg sm:text-xl font-semibold text-slate-800 truncate">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Auth Menu -->
                    @auth
                    <div class="flex items-center gap-3 relative">
                        <i class="fa-regular fa-bell text-slate-500 cursor-pointer hover:text-slate-700 text-sm sm:text-base mr-2"></i>
                        <button id="profileDropdownBtn" class="flex items-center gap-2 focus:outline-none">
                            <span class="text-sm font-medium text-slate-700 hidden sm:block">{{ Auth::user()->name ?? '' }}</span>
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="hidden absolute right-0 top-12 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                <i class="fa-regular fa-user w-4 mr-2 text-slate-400"></i> My Profile
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4 mr-2 text-rose-400"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-1.5 rounded-md text-sm font-medium transition shadow-sm">
                        Login Coach
                    </a>
                    @endauth
                </div>
            </header>

            <main class="p-4 sm:p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Responsive Sidebar Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (backdrop) backdrop.addEventListener('click', closeSidebar);

        // Profile Dropdown Script
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
