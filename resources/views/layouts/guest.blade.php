<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ASSA Swimming')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full">
        <div class="text-center mb-8">
            <div class="inline-block bg-white p-3 rounded-2xl shadow-sm border border-slate-100 mb-4">
                <img src="{{ asset('images/ASSAswim.png') }}" alt="ASSA Swimming Logo" class="h-12 object-contain">
            </div>
            <h1 class="text-2xl font-bold text-slate-800">ASSA Swimming</h1>
        </div>
        
        @yield('content')
        
        <div class="text-center mt-8 text-xs text-slate-400">
            &copy; {{ date('Y') }} ASSA Swimming. All rights reserved.
        </div>
    </div>
</body>
</html>
