@extends('layouts.app')

@section('content')
    <div class="flex flex-col h-screen bg-gray-100">

        {{-- 1. CABECERA (Igual a la anterior para mantener consistencia) --}}
        <div class="bg-[#DA291C] text-white p-4 shadow-md flex justify-between items-center z-10 shrink-0">

            {{-- Botón Volver --}}
            {{-- Usamos url()->previous() para volver inteligentemente a la categoría o lista --}}
            <a href="{{ url()->previous() }}"
               class="flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 rounded-xl
                  transition font-bold uppercase tracking-wider text-sm border border-white/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </a>

            {{-- Título del Producto --}}
            <div class="text-right">
                <span class="block text-xs font-bold opacity-80 uppercase tracking-widest">Configurar Vencimiento para:</span>
                <h2 class="text-3xl font-extrabold uppercase italic tracking-tighter">
                    {{ $product->name }}
                </h2>
            </div>
        </div>

        {{-- 2. ÁREA DE REGLAS (SCROLLABLE) --}}
        <div class="flex-grow p-4 overflow-y-auto bg-gray-200">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-20">
                @foreach($rules as $rule)

                    {{-- TARJETA INDIVIDUAL (FORMULARIO) --}}
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col border-2 border-transparent hover:border-[#DA291C] transition-colors duration-300">

                        <form action="{{ route('print.ticket', $rule) }}" method="POST" class="flex flex-col h-full">
                            @csrf
                            {{-- Datos Ocultos necesarios para el controlador --}}
                            <input type="hidden" name="rule_id" value="{{ $rule->id }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="category_id" value="{{ $category }}">
                            {{-- A. CABECERA DE LA TARJETA (Ubicación) --}}
                            <div class="bg-[#27251F] text-white p-4 text-center">
                                <h3 class="text-2xl font-black uppercase tracking-tight">{{ $rule->location }}</h3>
                                <div class="text-[#FFC72C] text-sm font-bold">Duración: {{ $rule->duration_minutes }} min</div>
                            </div>

                            {{-- B. CUERPO (Cálculos y Ajustes) --}}
                            <div class="p-6 flex-grow flex flex-col justify-center items-center space-y-4">

                                {{-- Visualización de la Hora (Estimada) --}}
                                <div class="text-center">
                                    <span class="text-gray-500 text-sm font-bold uppercase">Vencimiento Estándar</span>
                                    <div class="text-5xl font-black text-[#DA291C] tracking-tighter">
                                        {{ now()->addMinutes($rule->duration_minutes)->format('H:i') }}
                                    </div>
                                </div>

                                <hr class="w-full border-gray-200">

                                {{-- Input de Ajuste de Tiempo --}}
                                <div class="w-full">
                                    <label class="block text-gray-600 text-xs font-bold uppercase mb-2 text-center">
                                        ¿Ya fue elaborado? (Restar minutos)
                                    </label>
                                    <div class="relative">
                                        <input type="number"
                                               name="offset_minutes"
                                               value="0"
                                               min="0"
                                               class="w-full bg-gray-100 text-center text-3xl font-bold text-gray-800 p-4 rounded-xl border-2 border-gray-300 focus:border-[#DA291C] focus:bg-white focus:outline-none transition-all placeholder-gray-300 appearance-none">
                                        <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-bold text-sm">MIN</span>
                                    </div>
                                </div>

                            </div>

                            {{-- C. BOTÓN DE IMPRIMIR (Pie de página) --}}
                            <div class="p-4 bg-gray-50">
                                <button type="submit"
                                        class="w-full py-5 bg-[#FFC72C] text-[#27251F] border-b-8 border-[#E39F00]
                                           rounded-2xl shadow-md text-2xl font-black uppercase tracking-tight
                                           transform transition-all duration-150 hover:-translate-y-1 active:border-b-0 active:translate-y-2 hover:bg-[#ffcd42]
                                           flex items-center justify-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#DA291C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Imprimir Ticket
                                </button>
                            </div>

                        </form>
                    </div>

                @endforeach
            </div>

        </div>
    </div>
@endsection
