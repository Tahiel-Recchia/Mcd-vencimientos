<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveTimer extends Model
{
  //  use HasFactory;

    protected $fillable = [
        'product_id',
        'expiration_rule_id',
        'started_at',
        'expires_at',
        'is_active'
    ];


    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function expirationRule() {
        return $this->belongsTo(ExpirationRule::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function scopeVisibleInDashboard($query){
        return $query->where('is_active', true)
            ->orderBy('expires_at', 'asc')
            ->with(['product', 'expirationRule']);
    }

    public function deleteTimer($categoryId){
        if ($this->categories()->count() > 1 && $categoryId) {
            $this->categories()->detach($categoryId);
            return [
                'status' => 'ok',
                'message' => 'Desvinculado de esta categoría'
            ];
        } else {
            $this->update(['is_active' => false]);
            $this->categories()->detach();
            return ['status' => 'ok', 'message' => 'Timer desactivado globalmente'];
        }
    }

    public function updateTimer(){

    }


}
