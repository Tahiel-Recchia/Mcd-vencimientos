<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpirationRule;
use App\Models\ActiveTimer;
use App\Services\TicketService;
use App\Models\Category;
class PrintController extends Controller
{

    public function print(Request $request, ExpirationRule $rule, TicketService $ticketService)
    {
        $data = $this->getExpirationDate($request, $rule);
        $result = $ticketService->printTicket($data);
        $category = Category::find($request->category_id);
        if ($result === true) {
            $category->activeTimers()->create([
                'product_id' => $rule->product_id,
                'expiration_rule_id' => $rule->id,
                'started_at' => $data['elaborationTime'],
                'expires_at' => $data['expirationTime'],
            ]);
            return redirect()->route('dashboard.view');
        } else {
            dd("FALLO LA IMPRESION:", $result);
        }
    }
    private function getExpirationDate(Request $request, ExpirationRule $rule){
        $product = $rule->product;
        $offsetMinutes = $request->input('offset_minutes', 0);
        $defrostingMinutes = $rule->defrosting_time ?? 0;
        $location = $rule->location;
        $calculatedDates = $rule->calculateExpirationDate($product, $defrostingMinutes, $offsetMinutes, $location);
        $calculatedDates['raw_defrosting_minutes'] = $defrostingMinutes;

        return $calculatedDates;
    }



}
