@extends('layouts.app')

@section('content')

    <div class="theme-cocina flex flex-col h-screen bg-puesto-app transition-colors duration-300">

        @section('header_right')
            <a href="{{ route('dashboard.global') }}"
               class="hidden md:flex items-center px-4 py-2 bg-black/10 hover:bg-black/20 rounded-lg border border-white/20 transition text-xs font-bold uppercase tracking-wider">
                Dashboard Global
            </a>
        @endsection

        {{-- ÁREA DE SELECCIÓN --}}
        <div class="flex-grow p-4 md:p-8 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 h-full pb-10">
                @foreach($categories as $categoria)
                    <a href="{{ route('category.products', $categoria->id) }}"
                       class="group relative flex flex-col items-center justify-center p-6
                              {{ $categoria->styles['theme'] }}
                              bg-puesto-btn text-puesto-btn-text border-b-[8px] border-puesto-btn-border
                              hover:bg-puesto-btn-hover-bg hover:text-puesto-btn-hover-text
                              rounded-3xl shadow-xl hover:shadow-2xl
                              transform transition-all duration-200 hover:-translate-y-2 hover:scale-[1.01]
                              active:scale-95 active:border-b-0 active:translate-y-2 h-full min-h-[160px]">

                        {{-- ICONO CENTRAL PRINCIPAL --}}
                        <div class="mb-4 text-puesto-accent">
                            <x-dynamic-component
                                :component="'icons.' . $categoria->styles['icon']"
                                class="h-12 w-12 md:h-16 md:w-16 transition-transform group-hover:scale-110"
                            />
                        </div>

                        {{-- NOMBRE DE LA CATEGORÍA --}}
                        <span class="text-3xl md:text-5xl font-black uppercase tracking-tighter text-center z-10 leading-none">
                            {{ $categoria->name }}
                        </span>
                        <div class="w-12 h-1.5 md:w-20 md:h-2 mt-4 rounded-full opacity-50 bg-puesto-accent">
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
