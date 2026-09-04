<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ASSA Swimming')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/ASSAswim.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">
    
    <!-- Left Section: Image (Hidden on small screens) -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-cyan-900">
        <div class="absolute inset-0 bg-cyan-900/40 z-10 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-cyan-900/80 to-transparent z-10"></div>
        <img src="{{ asset('images/background pendaftaran.jpeg') }}" alt="Swimming Pool" class="absolute inset-0 w-full h-full object-cover">        
        <div class="relative z-20 flex flex-col justify-end p-12 text-white h-full">
            <h2 class="text-4xl font-bold mb-4">ASSA Swimming</h2>
            <p class="text-lg text-cyan-100 max-w-md">Kembangkan potensi renangmu bersama pelatih profesional dan jadwal yang terstruktur dengan baik.</p>
        </div>
    </div>

    <!-- Right Section: Form -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 sm:p-12 lg:p-24 bg-white relative">
        <div class="w-full max-w-md">
            <!-- Logo for mobile only -->
            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('images/ASSAswim.png') }}" alt="ASSA Swimming Logo" class="h-12 object-contain mx-auto mb-4">
                <h1 class="text-2xl font-bold text-slate-800">ASSA Swimming</h1>
            </div>

            <!-- Content Area -->
            @yield('content')

            <div class="text-center mt-12 text-xs text-slate-400">
                &copy; {{ date('Y') }} ASSA Swimming. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>
