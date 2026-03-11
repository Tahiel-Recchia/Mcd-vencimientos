@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto py-8 px-4 min-h-screen overflow-y-auto">
        <h1 class="text-4xl font-black text-center mb-10 text-gray-800">Estadísticas por Área</h1>

        @php
            // Definimos las columnas una sola vez al principio
            $columnas = [
                ['titulo' => '🗑️ Más Eliminados', 'key' => 'eliminados'],
                ['titulo' => '⏰ Más Vencidos', 'key' => 'vencidos'],
                ['titulo' => '🔄 Más Renovados', 'key' => 'renovados'],
            ];
        @endphp


        @foreach($estadisticas as $nombreCategoria => $datos)

            @php
                // Aplicamos tu sistema de temas dinámico
                $themeClass = $datos['modelo']->styles['theme'] ?? 'theme-cocina';
            @endphp

            <div class="{{ $themeClass }} mb-12 rounded-2xl shadow-xl overflow-hidden" style="background-color: var(--bg-app);">

                <div class="px-6 py-4 shadow-sm" style="background-color: var(--bg-header); color: var(--text-header);">
                    <h2 class="text-3xl font-black uppercase tracking-widest text-center">
                        {{ $nombreCategoria }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">

                    @foreach($columnas as $columna)
                        <div class="bg-puesto-soft rounded-xl p-5 border shadow-sm" style="border-color: var(--btn-border);">

                            <h3 class="text-xl font-bold mb-4 text-center border-b-2 pb-2" style="color: var(--btn-text); border-color: var(--btn-border);">
                                {{ $columna['titulo'] }}
                            </h3>

                            <ul class="space-y-3">
                                @forelse($datos[$columna['key']] as $item)

                                    @if($loop->first)
                                        <li class="flex items-center justify-between p-4 rounded-xl shadow-md font-black text-xl transform hover:scale-105 transition-transform"
                                            style="background-color: var(--btn-bg); color: var(--btn-text); border: 2px solid var(--btn-border);">
                                            <div class="flex items-center gap-3">
                                                <span class="text-black-400 font-bold w-5 text-center">#{{ $loop->iteration }}</span>
                                                <span class="tracking-tight">{{ $item->producto }}</span>
                                            </div>
                                            <span class="bg-white/60 px-4 py-1 rounded-full text-lg shadow-inner">
                                            {{ $item->total }}
                                        </span>
                                        </li>
                                    @else
                                        <li class="flex items-center justify-between p-3 rounded-lg bg-white shadow-sm border-l-4"
                                            style="border-left-color: var(--btn-border); color: var(--btn-text);">
                                            <div class="flex items-center gap-3">
                                                <span class="text-gray-400 font-bold w-5 text-center">#{{ $loop->iteration }}</span>
                                                <span class="font-semibold text-gray-700">{{ $item->producto }}</span>
                                            </div>
                                            <span class="font-bold bg-gray-100 px-3 py-1 rounded-full text-sm">
                                            {{ $item->total }}
                                        </span>
                                        </li>
                                    @endif

                                @empty
                                    <li class="text-center text-sm py-6 opacity-60 font-medium italic" style="color: var(--btn-text);">
                                        Sin registros por ahora
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach

    </div>

@endsection
