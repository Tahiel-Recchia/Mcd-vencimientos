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
        $result = $timer->deleteTimer($categoryId);

        return response()->json($result);

    }

    public function updateTimer($timerId, TicketService $ticketService)
    {
        $timer = ActiveTimer::find($timerId);

        if (!$timer) return response()->json(['status' => 'error', 'message' => 'Timer no encontrado'], 404);

        $rule = $timer->expirationRule;
        $product = $rule->product;
        $calculatedDates = $rule->calculateExpirationDate($product, $rule->defrosting_time, 0, $rule->location);

        $printResult = $ticketService->printUpdateTicket($product, $rule, $calculatedDates);

        if ($printResult === true) {
            $timer->update([
                'started_at' => $calculatedDates['elaborationTime'],
                'expires_at' => $calculatedDates['expirationTime'],
            ]);

            return response()->json([
                'status' => 'ok',
                'new_expiration_display' => $calculatedDates['expirationTime']->format('H:i:s'),
                'new_expiration_iso' => $calculatedDates['expirationTime']->toIso8601String(),
                'elaborationTime' => $calculatedDates['elaborationTime']->format('H:i d/m'),
                'expirationTime' => $calculatedDates['expirationTime']->format('H:i d/m'),
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Error de impresora: ' . $printResult], 500);
    }

    public function importTimer($timerId, $categoryId, TicketService $ticketService)
    {
        $category = Category::findOrFail($categoryId);
        $timer = ActiveTimer::with(['product', 'expirationRule'])->findOrFail($timerId);
        $result = $category->activeTimers()->syncWithoutDetaching([$timerId]);

        if (empty($result['attached'])) {
            return response()->json([
                'success' => false,
                'message' => 'El timer ya existe en esa categoría'
            ], 409);
        }

        try {
            \Log::info("Intentando imprimir ticket para: " . $timer->product->name);

            $rule = $timer->expirationRule;

            $defrostingMinutes = $rule ? (int)$rule->defrosting_time : 0;


            $location = $rule ? ($rule->location ?? 'General') : 'General';


            $startedAt = Carbon::parse($timer->started_at);
            $expiresAt = Carbon::parse($timer->expires_at);


            $defrostingDateFormatted = $startedAt->copy()->addMinutes($defrostingMinutes);

            $ticketData = [
                'productName' => $timer->product->name,
                'productLocation' => $location,
                'elaborationTime' => $startedAt,
                'expirationTime' => $expiresAt,
                'raw_defrosting_minutes' => $defrostingMinutes,
                'defrostingTime' => $defrostingDateFormatted,
            ];

            $ticketService->printTicket($ticketData);
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
        $timer = ActiveTimer::with(['categories', 'product.category'])->findOrFail($timerId);

        $currentCategoryIds = $timer->categories->pluck('id')->toArray();
        $allowedCategories = $timer->product->category;

        $data = $allowedCategories->map(function($category) use ($currentCategoryIds) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'is_present' => in_array($category->id, $currentCategoryIds)
            ];
        });

        return response()->json($data);
    }
}
