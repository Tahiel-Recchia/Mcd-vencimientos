<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\ActiveTimer;
use App\Services\TicketService;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('category')) {
            return redirect()->route('index');
        }
        $categoryId = session('category');
        $category = Category::find($categoryId);
        $timers = $category->activeTimers()->where('is_active', true)
            ->visibleInDashboard()->get();

        return view('dashboard', compact('timers', 'category'));
    }


    public function globalDashboard()
    {
        $categories = Category::with(['activeTimers' => function ($query) {
            $query->visibleInDashboard();
        }])->get();

        return view('globalDashboard', compact('categories'));
    }

    public function deleteTimer($timerId, $categoryId)
    {
        $timer = ActiveTimer::find($timerId);
        if (!$timer) return response()->json(['success' => false, 'message' => 'Timer no encontrado'], 404);
        $result = $timer->deleteTimer();

        return response()->json($result);

    }

    public function updateTimer($timerId, TicketService $ticketService)
    {
        $timer = ActiveTimer::find($timerId);

        if (!$timer) return response()->json(['status' => 'error', 'message' => 'Timer no encontrado'], 404);

        $rule = $timer->expirationRule;
        $product = $rule->product;
        $calculatedDates = $rule->calculateExpirationDate($product, $rule->defrosting_time, 0, $rule->location);
        $category = $timer->category;
        $printResult = $ticketService->printUpdateTicket($product, $rule, $calculatedDates);

        if ($printResult === true) {

            $timer->updateTimer();

            $newTimer = $category->activeTimers()->create([
                'product_id' => $rule->product_id,
                'expiration_rule_id' => $rule->id,
                'started_at' => $calculatedDates['elaborationTime'],
                'expires_at' => $calculatedDates['expirationTime'],
            ]);

            return response()->json([
                'status' => 'ok',
                'new_expiration_display' => $calculatedDates['expirationTime']->format('H:i:s'),
                'new_expiration_iso' => $calculatedDates['expirationTime']->toIso8601String(),
                'elaborationTime' => $calculatedDates['elaborationTime']->format('H:i d/m'),
                'expirationTime' => $calculatedDates['expirationTime']->format('H:i d/m'),
                'new_timer_id' => $newTimer->id,
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Error de impresora: ' . $printResult], 500);
    }

    public function importTimer($timerId, $categoryId, TicketService $ticketService)
    {
        $timer = ActiveTimer::findOrFail($timerId);
        $searchedCategory = Category::findOrFail($categoryId);

        $exists = $searchedCategory->activeTimers()
            ->where('group_id', $timer->group_id)
            ->exists();


        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'El timer ya existe en esa categoría'
            ], 409);
        }

        $importedTimer = $timer->import($categoryId);

        try {
            \Log::info("Intentando imprimir ticket para: " . $importedTimer->product->name);

            $ticketService->printTicket($importedTimer->getTicketData());
            \Log::info("Ticket enviado correctamente.");

        } catch (\Exception $e) {
            \Log::error("Error imprimiendo ticket: " . $e->getMessage());

        }

        session(['category' => $categoryId]);

        return response()->json([
            'success' => true,
            'message' => 'El timer se ha importado exitosamente'
        ]);
    }

    public function getCategoriesFromProduct($timerId)
    {
        $timer = ActiveTimer::with(['category', 'product.category'])->findOrFail($timerId);
        $data = $timer->getImportOptions();
        if($data){
            return response()->json(['success' => true, 'options' => $data]);
        }
        return response()->json(['success' => false, 'message' => 'No se encontraron resultados']);
    }

    public function getAllStadisticsFromTimers(){
        $elminated = ActiveTimer::getAllEliminatedTimers();
        return response()->json($elminated);
    }
}
