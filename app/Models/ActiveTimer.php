<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ActiveTimer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_id',
        'expiration_rule_id',
        'started_at',
        'expires_at',
        'is_active',
        'state'
    ];

protected static function boot()
{
    parent::boot();
    static::creating(function ($timer) {
        if (empty($timer->group_id)) {
            $timer->group_id = (string) Str::uuid();
        }
    });
}


    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function expirationRule() {
        return $this->belongsTo(ExpirationRule::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeVisibleInDashboard($query){
        return $query->where('is_active', true)
            ->orderBy('expires_at', 'asc')
            ->with(['product', 'expirationRule']);
    }

    public function deleteTimer(){
            if($this->expires_at <= Carbon::now()){
                $this->update(['is_active' => false, 'state' => 'expired']);
            } else {
                $this->update(['is_active' => false, 'state' => 'eliminated']);
            }

            return ['status' => 'ok', 'message' => 'Timer desactivado globalmente'];
    }

    public function getTicketData(){
        $defrostingMinutes = $this->expirationRule->defrosting_time;
       return $ticketData = [
            'productName' => $this->product->name,
            'productLocation' => $this->expirationRule->location,
            'elaborationTime' => Carbon::parse($this->startedAt),
            'expirationTime' => Carbon::parse($this->expiresAt),
            'raw_defrosting_minutes' => $defrostingMinutes,
            'defrostingTime' => Carbon::parse($this->startedAt)->copy()->addMinutes($defrostingMinutes),
        ];
    }

    public function getImportOptions(){
        $allowedCategories = $this->product->category;

       return $allowedCategories->map(function($category)  {

           $isPresent = $category->activeTimers()
               ->where('group_id', $this->group_id)
               ->exists();

            return [
                'id' => $category->id,
                'name' => $category->name,
                'is_present' => $isPresent
            ];
        });

    }



    public function updateTimer(){
        $this->update(['is_active' => false, 'state' => 'updated']);
    }

    public function import($categoryId){
        $clon = $this->replicate();
        $clon->save();
        $clon->update(['category_id' => $categoryId]);

        return $clon;
    }

    public static function getAllStadisctics(){
        return DB::table('active_timers')
            ->join('products', 'active_timers.product_id', '=', 'products.id')
            ->join('categories', 'active_timers.category_id', '=', 'categories.id')
            ->select(
                'products.name as producto',
                'categories.id as category_id',
                'categories.name as categoria',
                'active_timers.state as estado',
                DB::raw('COUNT(active_timers.id) as total')
            )
            ->whereIn('active_timers.state', ['eliminated', 'expired', 'updated'])
            ->groupBy('categories.id', 'categories.name', 'active_timers.state', 'products.name')
            ->orderByDesc('total')
            ->orderBy('products.name')
            ->get();
    }

}
