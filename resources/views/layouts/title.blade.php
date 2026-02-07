<div class="bg-[#DA291C] text-white p-4 shadow-xl flex justify-between items-center shrink-0 z-20 relative">

    {{-- Logo / Título --}}

    <div class="flex flex-col">
        <a href="{{ route('index') }}">
        <h1 class="text-3xl font-extrabold tracking-tighter uppercase italic leading-none">
            MCD <span class="text-[#FFC72C]">Vencimientos</span>
        </h1>
        <span class="text-xs font-medium opacity-80 uppercase tracking-widest ml-1">Sistema de Control</span>
        </a>
    </div>


    {{-- Reloj y Botón Dashboard --}}
    <div class="flex items-center gap-3">

        {{-- Botón Dashboard (Acceso rápido) --}}
        @if(request()->routeIs('index'))
            <a href="{{ route('dashboard.global') }}"
        @else
            <a href="{{ route('dashboard.view') }}"
        @endif
           class="hidden md:flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg border border-white/20 transition text-sm font-bold uppercase tracking-wider">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Dashboard
        </a>

        @endif

        {{-- Hora --}}
        <div class="bg-black/20 px-4 py-2 rounded-lg font-mono font-bold text-xl border border-white/10">
            {{ now()->format('H:i') }}
        </div>
    </div>
</div>

