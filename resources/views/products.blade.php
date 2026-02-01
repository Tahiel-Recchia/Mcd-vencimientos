@extends('layouts.app')

@section('content')

    {{-- LÓGICA DE ESTILOS POR ENTORNO --}}
    @php
        // Normalizamos el nombre para evitar errores (minusculas y sin acentos si fuera necesario)
        $catName = strtolower($category->name);

        // Definimos los colores por defecto (Cocina / General)
        $theme = [
            'bg_app'      => 'bg-gray-100',           // Fondo de la pantalla
            'bg_header'   => 'bg-[#DA291C]',          // Rojo McDonald's
            'text_header' => 'text-white',
            'btn_card'    => 'bg-[#FFC72C] text-[#27251F] border-[#E39F00]', // Botón Amarillo Clásico
            'btn_hover'   => 'hover:bg-[#ffcf4b]',
            'icon_color'  => 'text-[#DA291C]'
        ];

        // Personalización según la categoría
        if (str_contains($catName, 'caf') || str_contains($catName, 'mccaf')) {
            // TEMA MCCAFÉ: Tonos Café, Beige y Madera
            $theme = [
                'bg_app'      => 'bg-[#4B3621]', // Marrón oscuro fondo
                'bg_header'   => 'bg-[#1a120b]', // Marrón casi negro header
                'text_header' => 'text-[#d6c0a1]', // Beige texto
                'btn_card'    => 'bg-[#F5EDCB] text-[#4B3621] border-[#C2A878]', // Beige latte
                'btn_hover'   => 'hover:bg-[#fff9e1]',
                'icon_color'  => 'text-[#6F4E37]'
            ];
        }
        elseif (str_contains($catName, 'isla') || str_contains($catName, 'postres') || str_contains($catName, 'helado')) {
            // TEMA ISLA: Tonos Frescos, Rosa/Cyan (Vibra de McFlurry)
            $theme = [
                'bg_app'      => 'bg-cyan-50',
                'bg_header'   => 'bg-pink-500',
                'text_header' => 'text-white',
                'btn_card'    => 'bg-white text-pink-600 border-cyan-300',
                'btn_hover'   => 'hover:bg-cyan-50',
                'icon_color'  => 'text-cyan-500'
            ];
        }
        elseif (str_contains($catName, 'servicio') || str_contains($catName, 'mostrador')) {
            // TEMA SERVICIO: Azul Corporativo o Verde (Eficiencia/Atención)
            $theme = [
                'bg_app'      => 'bg-slate-200',
                'bg_header'   => 'bg-blue-700',
                'text_header' => 'text-white',
                'btn_card'    => 'bg-white text-blue-900 border-blue-200',
                'btn_hover'   => 'hover:bg-blue-50',
                'icon_color'  => 'text-blue-600'
            ];
        }
    @endphp

    {{-- Contenedor Principal con el color de fondo dinámico --}}
    <div class="flex flex-col h-screen {{ $theme['bg_app'] }} transition-colors duration-300">

        {{-- 1. CABECERA --}}
        <div class="{{ $theme['bg_header'] }} {{ $theme['text_header'] }} p-4 shadow-xl flex justify-between items-center z-20 shrink-0 relative">

            {{-- A. Botón Volver --}}
            <a href="{{ route('index') }}"
               class="flex items-center px-5 py-2 bg-white/10 hover:bg-white/20 rounded-xl
                  transition font-bold uppercase tracking-wider text-xs md:text-sm border border-white/20 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Categorías
            </a>

            {{-- B. Título de la Categoría --}}
            <h2 class="text-2xl md:text-4xl font-black uppercase italic tracking-tighter absolute left-1/2 transform -translate-x-1/2 text-center w-full pointer-events-none opacity-90">
                {{ $category->name }}
            </h2>

            {{-- C. BOTÓN DASHBOARD (NUEVO) --}}
            <a href="{{ route('dashboard.view') }}"
               class="flex items-center px-5 py-2 bg-white/90 hover:bg-white text-gray-800 rounded-xl shadow-lg
                      transition transform hover:scale-105 font-bold uppercase text-xs md:text-sm border-b-4 border-gray-300 active:border-b-0 active:translate-y-1">
                <span>Dashboard</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-green-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </a>
        </div>

        {{-- 2. ÁREA DE PRODUCTOS --}}
        <div class="flex-grow p-4 overflow-y-auto">

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-24">
                @foreach($products as $producto)

                    <form action="{{ route('product.rules', $producto->id) }}" method="POST" class="h-40 md:h-48">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <input type="hidden" name="category_id" value="{{ $category->id }}">

                        {{-- Botón del Producto con Colores Dinámicos --}}
                        <button type="submit"
                                class="group w-full h-full relative flex flex-col items-center justify-center p-4
                                   {{ $theme['btn_card'] }} {{ $theme['btn_hover'] }} border-b-[6px]
                                   rounded-2xl shadow-md hover:shadow-2xl
                                   transform transition-all duration-150 hover:-translate-y-1
                                   active:border-b-0 active:translate-y-1 focus:outline-none overflow-hidden">

                            {{-- Decoración de fondo sutil --}}
                            <div class="absolute -right-4 -bottom-4 opacity-10 transform rotate-12 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/>
                                </svg>
                            </div>

                            {{-- Icono de acción (Imprimir) --}}
                            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity {{ $theme['icon_color'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </div>

                            {{-- Nombre del Producto --}}
                            <span class="text-xl md:text-2xl font-black uppercase leading-none text-center break-words w-full z-10">
                                {{ $producto->name }}
                            </span>
                        </button>
                    </form>

                @endforeach
            </div>

        </div>
    </div>
@endsection
