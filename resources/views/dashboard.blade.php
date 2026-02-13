@extends('layouts.app')
@extends('layouts.notification')

@section('content')

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

            {{-- MODAL DE IMPORTACIÓN --}}
            <div id="import-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                {{-- Fondo oscurecido --}}
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeImportModal()"></div>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                        {{-- Contenido del Modal --}}
                        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border-t-8 border-slate-500">

                            {{-- Cabecera --}}
                            <div class="bg-gray-50 px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-100">
                                <h3 class="text-xl font-black leading-6 text-gray-800 uppercase italic tracking-tighter" id="modal-title">
                                    Importar Vencimiento
                                </h3>
                                <button type="button" data-action="closeImportModal" class="btn-action text-gray-400 hover:text-gray-500 transition-colors">
                                    <span class="sr-only">Cerrar</span>
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Cuerpo con Información del Timer --}}
                            <div class="px-4 py-6 sm:p-6">

                                {{-- Tarjeta de Resumen del Producto --}}
                                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 text-center">
                                    <span class="block text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Producto a Importar</span>
                                    <h4 id="modal-product-name" class="text-2xl font-black text-gray-800 uppercase leading-none mb-2">
                                        ---
                                    </h4>
                                    <div class="inline-flex items-center gap-1 bg-white px-3 py-1 rounded-full border border-blue-100 shadow-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span id="modal-product-location" class="text-xs font-bold text-gray-500 uppercase">---</span>
                                    </div>
                                </div>

                                {{-- Título de Selección --}}
                                <div class="text-center mb-4">
                                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Seleccione el sector de destino</p>
                                </div>

                                {{-- Input oculto para guardar el ID del timer --}}
                                <input type="hidden" id="modal-timer-id">

                                {{-- Lista de Categorías --}}
                                <div id="modal-categories-list" class="grid grid-cols-1 gap-3">
                                </div>

                                {{-- Estado Vacío  --}}
                                <div id="modal-empty-state" class="hidden text-center py-4">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 mb-3">
                                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-gray-600 uppercase">El producto no pertenece a ningún otro sector</p>
                                </div>

                            </div>

                            {{-- Pie del Modal --}}
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button" data-action="closeImportModal" class="btn-action mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-black text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto uppercase tracking-wide">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            {{-- TARJETA --}}
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

                                    {{-- RELOJ --}}
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

                                {{-- BOTONERA --}}
                                <div class="grid grid-cols-3 h-16 border-t border-gray-100 divide-x divide-gray-100">

                                    {{-- 1. BOTÓN ELIMINAR  --}}
                                    <button type="button"
                                            data-action="delete"
                                            data-timer-id="{{ $timer->id}}"
                                            data-category-id="{{ $category->id }}"
                                            class="btn-action bg-red-50 hover:bg-red-100 text-red-600 flex flex-col items-center justify-center transition-colors active:bg-red-200 group">
                                        <svg class="w-5 h-5 mb-0.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="text-[9px] font-black uppercase">Eliminar</span>
                                    </button>

                                    {{-- 2. BOTÓN IMPORTAR --}}

                                    <button type="button"
                                            data-action="import"
                                            data-timer-id="{{ $timer->id }}"
                                           data-product-name="{{$timer->product->name}}"
                                            data-location="{{$timer->expirationRule->location ?? 'General'}}"
                                            class="btn-action btn-action-timer bg-slate-100 hover:bg-slate-200 text-slate-600 flex flex-col items-center justify-center transition-colors active:bg-slate-300 group z-10">
                                        <svg class="w-5 h-5 mb-0.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        <span class="text-[9px] font-black uppercase">Importar</span>
                                    </button>

                                    {{-- 3. BOTÓN RENOVAR  --}}
                                    <button type="button"
                                            data-action="renew"
                                            data-timer-id="{{$timer->id}}"
                                            data-category-id="{{$category->id}}"
                                            class="btn-action bg-puesto-btn text-puesto-btn-text flex flex-col items-center justify-center transition-all hover:brightness-105 active:opacity-80 group">
                                        <svg class="w-5 h-5 mb-0.5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    </div>


@endsection
@push('scripts')
    @vite('resources/js/dashboardClickHandler.js')
@endpush



