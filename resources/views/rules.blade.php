
@extends('layouts.app')

@section('content')
    {{-- Contenedor Principal: Ocupa toda la pantalla --}}
    <div class="flex flex-col h-screen bg-gray-100">

        {{-- 1. CABECERA CON NAVEGACIÓN --}}
        {{-- Usamos el mismo rojo, pero agregamos el botón de volver --}}
        <div class="bg-[#DA291C] text-white p-4 shadow-md flex justify-between items-center z-10 shrink-0">

            {{-- Botón Volver (Estilo 'Ghost' para no competir con el título) --}}
            <a href="{{ route('index') }}"
               class="flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 rounded-xl
                  transition font-bold uppercase tracking-wider text-sm border border-white/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </a>

            {{-- Título de la Categoría --}}
            <h2 class="text-3xl font-extrabold uppercase italic tracking-tighter text-right">
                {{ $product->name }}
            </h2>
        </div>

        {{-- 2. ÁREA DE PRODUCTOS (SCROLLABLE) --}}
        {{-- 'overflow-y-auto' permite que solo esta parte haga scroll si hay muchos productos --}}
        <div class="flex-grow p-4 overflow-y-auto">

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-20">
                @foreach($rules as $rule)

                    {{-- Cada producto es un formulario que envía la orden de imprimir --}}
                    <form action="{{route('product.print', $product->id)}}" method="POST" class="h-48">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $rule->id }}">

                        <button type="submit"
                                class="group w-full h-full relative flex flex-col items-center justify-center p-6
                                   bg-[#FFC72C] text-[#27251F] border-b-8 border-[#E39F00]
                                   rounded-3xl shadow-lg hover:shadow-xl
                                   transform transition-all duration-150 hover:-translate-y-1
                                   active:border-b-0 active:translate-y-2 focus:outline-none">

                            {{-- Brillo superior decorativo --}}
                            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-white/20 to-transparent rounded-t-3xl pointer-events-none"></div>

                            {{-- Icono de Impresora (Se hace visible al pasar el mouse/tocar) --}}
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity text-[#DA291C]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </div>

                            {{-- Nombre del Producto --}}
                            <span class="text-2xl md:text-3xl font-black uppercase leading-tight text-center mt-2 break-words w-full">
                            {{ $rule->location }}
                        </span>


                        </button>
                    </form>

                @endforeach
            </div>

        </div>
    </div>
@endsection
