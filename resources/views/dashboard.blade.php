@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- REUTILIZAMOS TU LÓGICA DE TEMAS --}}
    @php
        // Asumiendo que pasas $category al dashboard o la detectas de alguna forma
        $catName = isset($category) ? strtolower($category->name) : 'general';

        // Tema Default (Cocina)
        $theme = [
            'bg_app'      => 'bg-gray-100',
            'bg_header'   => 'bg-[#DA291C]',
            'text_header' => 'text-white',
            'card_border' => 'border-gray-200'
        ];

        if (str_contains($catName, 'caf')) {
            $theme = ['bg_app' => 'bg-[#4B3621]', 'bg_header' => 'bg-[#1a120b]', 'text_header' => 'text-[#d6c0a1]', 'card_border' => 'border-[#6F4E37]'];
        } elseif (str_contains($catName, 'isla')) {
            $theme = ['bg_app' => 'bg-cyan-50', 'bg_header' => 'bg-pink-500', 'text_header' => 'text-white', 'card_border' => 'border-cyan-200'];
        }
    @endphp

    <div class="flex flex-col h-screen {{ $theme['bg_app'] }} transition-colors duration-300">

        {{-- CABECERA ESTILO MCDONALDS --}}
        <header class="{{ $theme['bg_header'] }} {{ $theme['text_header'] }} p-4 shadow-xl flex justify-between items-center z-20 shrink-0">
            <a href="{{ route('index') }}" class="flex items-center px-4 py-2 bg-white/10 rounded-xl font-bold uppercase text-xs border border-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </a>

            <h1 class="text-xl md:text-3xl font-black uppercase italic tracking-tighter">
                Panel de Vencimientos: {{ $category->name ?? 'Global' }}
            </h1>

            <div class="bg-white/20 px-3 py-1 rounded-lg font-bold text-sm">
                {{ $timers->count() }} ACTIVO(S)
            </div>
        </header>

        {{-- CONTENIDO SCROLLABLE --}}
        <div class="flex-grow p-4 overflow-y-auto">
            @if($timers->isEmpty())
                <div class="flex flex-col items-center justify-center h-64 opacity-50">
                    <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-2xl font-bold uppercase">No hay productos activos</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-20">
                    @foreach($timers as $timer)
                        <div id="timer-card-{{ $timer->id }}"
                             class="timer-card bg-white rounded-3xl shadow-xl border-b-[8px] flex flex-col overflow-hidden transform transition-all active:scale-95 {{ $theme['card_border'] }}"
                             data-expires="{{ $timer->expires_at }}">

                            <div class="p-5 flex-grow">
                                {{-- Nombre del Producto --}}
                                <div class="flex justify-between items-start">
                                    <h2 class="text-2xl font-black text-gray-800 leading-tight uppercase">
                                        {{ $timer->product->name }}
                                    </h2>
                                </div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    {{ $timer->expirationRule->location ?? 'General' }}
                                </span>

                                {{-- ÁREA DEL RELOJ (Fitts's Law: Grande para ver de lejos) --}}
                                <div class="mt-4 mb-4 py-6 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center relative overflow-hidden">
                                    <span class="timer-display text-5xl font-mono font-black text-gray-700 tabular-nums z-10">
                                        00:00:00
                                    </span>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter z-10">Tiempo para descarte</div>
                                </div>

                                {{-- Fechas pequeñas --}}
                                <div class="grid grid-cols-2 gap-2 text-[10px] font-bold text-gray-400 uppercase border-t pt-3">
                                    <div>Elab: <span class="text-gray-600 block">{{ \Carbon\Carbon::parse($timer->started_at)->format('H:i d/m') }}</span></div>
                                    <div class="text-right">Vence: <span class="text-gray-600 block">{{ \Carbon\Carbon::parse($timer->expires_at)->format('H:i d/m') }}</span></div>
                                </div>
                            </div>

                            {{-- BOTONERA TÁCTIL (Dual Action) --}}
                            <div class="grid grid-cols-2 h-20 border-t">
                                <button onclick="deleteTimer({{ $timer->id }})"
                                        class="bg-red-50 hover:bg-red-100 text-red-600 flex flex-col items-center justify-center border-r transition-colors active:bg-red-200">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span class="text-[10px] font-black uppercase">Eliminar</span>
                                </button>

                                <button onclick="renewTimer({{ $timer->id }})"
                                        class="bg-blue-50 hover:bg-blue-100 text-blue-600 flex flex-col items-center justify-center transition-colors active:bg-blue-200">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span class="text-[10px] font-black uppercase">Renovar</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
