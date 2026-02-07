@extends('layouts.app')
@extends('layouts.notification')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Contenedor principal con el tema del puesto --}}
    <div class="{{ $category->styles['theme'] ?? 'theme-cocina' }} flex flex-col h-screen bg-puesto-app transition-colors duration-300 font-sans">

        @section('header_left')
            <a href="{{ route('category.products', $category) }}" class="flex items-center px-4 py-2 bg-black/10 hover:bg-black/20 rounded-lg font-bold uppercase text-xs border border-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </a>
        @endsection

        @section('header_center')
            <h1 class="text-xl md:text-2xl font-black uppercase italic tracking-tighter leading-none">
                {{ $category->name }}
            </h1>
            <span class="text-[10px] opacity-70 uppercase font-bold tracking-widest">Panel de Control</span>
        @endsection

        @section('header_right')
            <div class="bg-black/10 px-4 py-2 rounded-lg font-bold text-sm border border-white/10">
                {{ $timers->count() }} ACTIVO(S)
            </div>
        @endsection

        {{-- CONTENIDO --}}
        <div class="flex-grow p-4 overflow-y-auto">
            @if($timers->isEmpty())
                <div class="flex flex-col items-center justify-center h-64 opacity-30 text-puesto-header">
                    <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-2xl font-bold uppercase text-center">No hay productos activos</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-20">
                        @foreach($timers as $timer)
                            {{-- TARJETA: Redondeado reducido a '2xl' y borde inferior de 6px --}}
                            <div id="timer-card-{{ $timer->id }}"
                                 class="timer-card bg-white rounded-2xl shadow-lg border-b-[6px] border-puesto-header flex flex-col overflow-hidden transform transition-all active:scale-95"
                                 data-expires="{{ $timer->expires_at }}">

                                <div class="p-5 flex-grow">
                                    <div class="mb-1">
                                        <h2 id="name-{{$timer->id}}" class="text-xl font-black text-gray-800 leading-tight uppercase">
                                            {{ $timer->product->name }}
                                        </h2>
                                        <span id="location-{{$timer->id}}" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            {{ $timer->expirationRule->location ?? 'General' }}
                                        </span>
                                    </div>

                                    {{-- RELOJ: Redondeado reducido a 'xl' --}}
                                    <div class="mt-4 mb-4 py-6 rounded-xl bg-gray-50 border border-gray-200 flex flex-col items-center justify-center relative">
                                        <span id="timer-{{$timer->id}}" class="timer-display text-4xl font-mono font-black text-gray-700 tabular-nums z-10">
                                            00:00:00
                                        </span>
                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Tiempo restante</div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 text-[10px] font-bold text-gray-400 uppercase border-t border-gray-100 pt-4">
                                        <div>Elab: <span id="elab-{{$timer->id}}-{{$category->id}}" class="text-gray-800 block">{{ \Carbon\Carbon::parse($timer->started_at)->format('H:i d/m') }}</span></div>
                                        <div class="text-right">Vence: <span id="vence-{{$timer->id}}-{{$category->id}}" class="text-puesto-header block">{{ \Carbon\Carbon::parse($timer->expires_at)->format('H:i d/m') }}</span></div>
                                    </div>
                                </div>

                                {{-- BOTONERA: Botón eliminar ahora es rojo sólido --}}
                                <div class="grid grid-cols-2 h-16 border-t border-gray-100">
                                    <button onclick="deleteTimer({{ $timer->id }})"
                                            class="bg-red-600 hover:bg-red-700 text-white flex flex-col items-center justify-center transition-colors active:brightness-90">
                                        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span class="text-[9px] font-black uppercase">Eliminar</span>
                                    </button>

                                    <button onclick="updateTimer({{ $timer->id, $category->id }})"
                                            class="bg-puesto-btn text-puesto-btn-text flex flex-col items-center justify-center transition-all hover:brightness-105 active:opacity-80">
                                        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span class="text-[9px] font-black uppercase">Renovar</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
