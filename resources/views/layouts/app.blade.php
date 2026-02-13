<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MCD Vencimientos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

<div id="app" class="{{ $category->styles['theme'] ?? 'theme-cocina' }} flex flex-col h-screen bg-puesto-app transition-colors duration-300 font-sans text-gray-800">

    {{-- HEADER UNIFICADO --}}
    <header class="bg-puesto-header text-puesto-header-text p-4 shadow-xl flex justify-between items-center z-20 shrink-0 relative">

        {{-- IZQUIERDA --}}
        <div class="flex items-center min-w-[150px]">
            @if(View::hasSection('header_left'))
                @yield('header_left')
            @else
                <a href="{{ route('index') }}" class="hover:opacity-90 transition-opacity flex flex-col">
                    <h1 class="text-2xl font-black tracking-tighter uppercase italic leading-none">
                        MCD <span class="text-puesto-btn">Vencimientos</span>
                    </h1>
                    <span class="text-[9px] font-medium opacity-70 uppercase tracking-[0.2em] ml-0.5">Control de Calidad</span>
                </a>
            @endif
        </div>

        {{-- CENTRO --}}
        <div class="text-center flex-grow px-4">
            @yield('header_center')
        </div>

        {{-- DERECHA --}}
        <div class="flex items-center justify-end gap-3 min-w-[150px]">
            @if(View::hasSection('header_right'))
                @yield('header_right')
            @else
                @if(!request()->routeIs('dashboard.*') && isset($category))
                    <a href="{{ route('dashboard.view', $category) }}"
                       class="hidden md:flex items-center px-4 py-2 bg-black/10 hover:bg-black/20 rounded-lg border border-white/20 transition text-xs font-bold uppercase tracking-wider">
                        Dashboard
                    </a>
                @endif
                <div id="header-clock" class="bg-black/20 px-4 py-2 rounded-lg font-mono font-bold text-xl border border-white/10 shadow-inner">
                    --:--
                </div>
            @endif
        </div>
    </header>

    {{-- CONTENIDO DE LA VISTA --}}
    <main class="flex-grow overflow-hidden">
        @yield('content')
    </main>
</div>

<script>
    function updateHeaderClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const el = document.getElementById('header-clock');
        if(el) el.textContent = `${hours}:${minutes}`;
    }
    setInterval(updateHeaderClock, 1000);
    updateHeaderClock();
</script>

@stack('scripts')
</body>
</html>
