@extends('layouts.app')

@section('content')

    {{--
        Recuerda que en tu controlador debes pasar las categorías:
        public function index() {
            $categories = Category::all();
            return view('categorias', compact('categories'));
        }
    --}}

    {{-- Contenedor Principal. Aquí se asigna el tema por defecto (p.ej., cocina) --}}
    {{-- Cuando no hay una categoría seleccionada, la base es "cocina" --}}
    <div class="theme-cocina flex flex-col h-screen bg-puesto-app transition-colors duration-300">

        {{-- CABECERA PRINCIPAL (Con colores del tema "cocina" por defecto) --}}
        <div class="bg-puesto-header text-puesto-header-text p-4 shadow-xl flex justify-between items-center z-20 shrink-0 relative">
            <h2 class="text-2xl md:text-4xl font-black uppercase italic tracking-tighter text-center w-full">
                Selecciona una Categoría
            </h2>
        </div>

        {{-- ÁREA DE SELECCIÓN (GRILLA DE BOTONES DE CATEGORÍA) --}}
        <div class="flex-grow p-4 md:p-8 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 h-full pb-10">
                @foreach($categories as $categoria)
                    <a href="{{ route('category.products', $categoria->id) }}"
                       class="group relative flex flex-col items-center justify-center p-6
                              {{ $categoria->styles['theme'] }} {{-- <--- AQUI SE APLICA EL TEMA ESPECÍFICO --}}
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

                        {{-- Barra decorativa debajo --}}
                        <div class="w-12 h-1.5 md:w-20 md:h-2 mt-4 rounded-full opacity-50 bg-puesto-accent">
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
