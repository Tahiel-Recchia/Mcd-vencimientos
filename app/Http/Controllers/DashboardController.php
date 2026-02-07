<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\ActiveTimer;
use App\Models\ExpirationRule;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Services\TicketService;

class DashboardController extends Controller
{
    public function index()
    {
        if(!session()->has('category')){
            return redirect()->route('index');
        }
        $categoryId = session('category');
        $category = Category::find($categoryId);
        $timers = $category->activeTimers()->where('is_active', true)
            ->with(['product', 'expirationRule'])
            ->orderBy('expires_at', 'asc')
            ->get();

        return view('dashboard', compact('timers', 'category'));
    }

  /*  public function globalDashboard(){
        $categories = Category::with(['timers' => function($query) {
            $query->where('status', 'active')
                ->orderBy('expires_at', 'asc');
        }])->get();
        return view('Globaldashboard', compact('categories'));
    }
  */

    public function globalDashboard() {
        $categories = Category::with(['activeTimers' => function($query) {
            $query->where('is_active', true)
            ->orderBy('expires_at', 'asc')
                ->with(['product', 'expirationRule']); // Cargamos las relaciones del timer
        }])
            ->get();

        return view('globalDashboard', compact('categories'));
    }

    public function deleteTimer($timerId, $categoryId) {
        $timer = ActiveTimer::find($timerId);
        if(!$timer) return response()->json(['success' => false, 'message' => 'Timer no encontrado'], 404);
        $categoriesCount = $timer->categories()->count();
        if($categoriesCount > 1 && $categoryId) {
            $timer->categories()->detach($categoryId);
            return response()->json([
                'status' => 'ok',
                'message' => 'Desvinculado de esta categoría'
            ]);
        } else {
            $timer->update(['is_active' => false]);
            $timer->categories()->detach();
            return response()->json(['success' => true, 'message' => 'Timer desactivado globalmente']);
        }

    }

    public function updateTimer($timerId, TicketService $ticketService) {
        $timer = ActiveTimer::find($timerId);

        if(!$timer) return response()->json(['status' => 'error', 'message' => 'Timer no encontrado'], 404);

        $rule = $timer->expirationRule;
        $product = $rule->product;

        // Calculamos nuevas fechas
        $expirationDate = $rule->calculateExpirationDate($product, $rule->defrosting_time, 0, $rule->location);

        $printResult = $ticketService->printTicket([
            'productName' => $product->name,
            'productLocation' => $rule->location,
            'elaborationTime' => $expirationDate['elaborationTime'],
            'expirationTime' => $expirationDate['expirationTime'],
            'raw_defrosting_minutes' => $rule->defrosting_time,
            'defrostingTime' => $expirationDate['defrostingTime'],
        ]);

        if ($printResult === true) {
            $timer->update([
                'started_at' => $expirationDate['elaborationTime'],
                'expires_at' => $expirationDate['expirationTime'],
            ]);

            return response()->json([
                'status' => 'ok',
                'new_expiration_display' => $expirationDate['expirationTime']->format('H:i:s'),
                'new_expiration_iso' => $expirationDate['expirationTime']->toIso8601String(),
                'elaborationTime' => $expirationDate['elaborationTime']->format('H:i d/m'),
                'expirationTime' => $expirationDate['expirationTime']->format('H:i d/m'),
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Error de impresora: ' . $printResult], 500);
    }

    public function importTimer($timerId, $categoryId) {
        $category = Category::findOrFail($categoryId);
        $result = $category->activeTimers()->syncWithoutDetaching([$timerId]);
        if(empty($result['attached'])) {
            return response()->json(['success' => false, 'message' => 'El timer ya existe en esa categoría']);
        }

        $category->activeTimers()->attach($timerId);

        return response()->json(['success' => true, 'message' => 'El timer se ha registrado exitosamente']);
    }

}
