<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActiveTimer;
use App\Models\Category;
class StadisticsController extends Controller
{
    public function mostrarEstadisticas()
    {
        // 1. Agrupamos por la columna category_id (A prueba de fallos)
        $datosCrudos = ActiveTimer::getAllStadisctics()->groupBy('category_id');

        // 2. Traemos TODAS las categorías reales
        $categorias = Category::all();

        $estadisticas = $categorias->mapWithKeys(function ($categoria) use ($datosCrudos) {

            // 3. Buscamos usando el ID exacto ($categoria->id)
            $itemsPorCategoria = $datosCrudos->get($categoria->id, collect());

            $porEstado = $itemsPorCategoria->groupBy('estado');

            return [
                $categoria->name => [
                    'modelo'     => $categoria,
                    'eliminados' => $porEstado->get('eliminated', collect())->take(5),
                    'vencidos'   => $porEstado->get('expired', collect())->take(5),
                    'renovados'  => $porEstado->get('updated', collect())->take(5),
                ]
            ];
        });

        // 💡 TIP DE DEBUGGING:
        // Descomenta la siguiente línea si quieres ver qué datos exactos se están enviando antes de la vista
        // dd($estadisticas->toArray());

        return view('stadistics', [
            'estadisticas' => $estadisticas
        ]);
    }
}
