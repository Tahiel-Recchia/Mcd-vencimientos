@extends('layouts.app')

@section('content')
    <div class="overflow-y-auto h-full bg-gray-200">

        @foreach($categories as $category)
            <section class="{{ $category->styles['theme'] ?? 'theme-cocina' }} bg-puesto-soft border-b border-gray-300 pb-12 pt-8">
                <div class="max-w-[1600px] mx-auto px-6">

                    {{-- Cabecera de la Sección --}}
                    <div class="flex items-end justify-between mb-8 border-b-4 border-puesto-header pb-2">
                        <div class="flex items-center gap-4">
                            <h2 class="text-4xl font-black uppercase italic tracking-tighter text-gray-800">
                                {{ $category->name }}
                            </h2>
                            <span class="px-4 py-1 bg-puesto-header text-puesto-header-text rounded-full text-sm font-black uppercase shadow-sm">
                                {{ $category->activeTimers->count() }} Activos
                            </span>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-[0.3em] mb-1">
                            Área de Control: {{ $category->name }}
                        </span>
                    </div>

                    {{-- Grilla de Productos --}}
                    @if($category->activeTimers->isEmpty())
                        <div class="bg-white/40 border-2 border-dashed border-gray-300 rounded-3xl p-12 text-center">
                            <p class="text-gray-400 font-bold uppercase text-lg italic tracking-widest">
                                No hay producciones activas en esta área
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                            @foreach($category->activeTimers as $timer)
                                {{-- TARJETA: Diseño unificado con ID compuesto para evitar conflictos --}}
                                <div id="timer-card-{{ $category->id }}-{{ $timer->id }}"
                                     class="timer-card bg-white rounded-2xl shadow-lg border-b-[6px] border-puesto-header flex flex-col overflow-hidden transform transition-all hover:scale-[1.02] active:scale-95"
                                     data-expires="{{ $timer->expires_at }}">

                                    <div class="p-5 flex-grow">
                                        <div class="mb-1">
                                            {{-- Nombre y Ubicación con IDs únicos --}}
                                            <h2 id="name-{{ $category->id }}-{{ $timer->id }}" class="text-xl font-black text-gray-800 leading-tight uppercase truncate">
                                                {{ $timer->product->name }}
                                            </h2>
                                            <span id="location-{{ $category->id }}-{{ $timer->id }}" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    {{ $timer->expirationRule->location ?? 'General' }}
                </span>
                                        </div>

                                        {{-- RELOJ: Estilo unificado --}}
                                        <div class="mt-4 mb-4 py-6 rounded-xl bg-gray-50 border border-gray-200 flex flex-col items-center justify-center relative">
                <span id="timer-{{ $category->id }}-{{ $timer->id }}" class="timer-display text-4xl font-mono font-black text-gray-700 tabular-nums z-10">
                    00:00:00
                </span>
                                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Tiempo restante</div>
                                        </div>

                                        {{-- Información de Fechas (Restaurada) --}}
                                        <div class="grid grid-cols-2 gap-4 text-[10px] font-bold text-gray-400 uppercase border-t border-gray-100 pt-4">
                                            <div>Elab: <span class="text-gray-800 block">{{ \Carbon\Carbon::parse($timer->started_at)->format('H:i d/m') }}</span></div>
                                            <div class="text-right">Vence: <span class="text-puesto-header block">{{ \Carbon\Carbon::parse($timer->expires_at)->format('H:i d/m') }}</span></div>
                                        </div>
                                    </div>

                                    {{-- BOTONERA: Diseño unificado con iconos y botón rojo sólido --}}
                                    <div class="grid grid-cols-2 h-16 border-t border-gray-100">
                                        <button onclick="deleteTimer({{ $timer->id }})"
                                                class="bg-red-600 hover:bg-red-700 text-white flex flex-col items-center justify-center transition-colors active:brightness-90">
                                            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="text-[9px] font-black uppercase">Eliminar</span>
                                        </button>

                                        <button onclick="updateTimer({{ $timer->id }})"
                                                class="bg-puesto-btn text-puesto-btn-text flex flex-col items-center justify-center transition-all hover:brightness-105 active:opacity-80">
                                            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <span class="text-[9px] font-black uppercase">Renovar</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
    </div>
@endsection

@push('scripts')
    @vite('resources/js/deleteTimer.js')
    @vite('resources/js/updateTimers.js')
@endpush
