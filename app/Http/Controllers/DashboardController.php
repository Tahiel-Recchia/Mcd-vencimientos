<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\ActiveTimer;
use Illuminate\Http\Request;

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

    public function globalDashboard(){
        $categories = Category::with(['timers' => function($query) {
            $query->where('status', 'active')
                ->orderBy('expires_at', 'asc'); // El que vence antes, aparece primero
        }])->get();
        return view('Globaldashboard', compact('categories'));
    }

    public function deleteTimer($timerId) {
        $timer = ActiveTimer::find($timerId);
        if($timer){
            $timer->update(['is_active' => false]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Timer no encontrado'], 404);
    }
}
