<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Product extends Model
{

    public function category(){
        return $this->belongsToMany(Category::class);
    }

    public function expirationRules()
    {
        return $this->hasMany(ExpirationRule::class);
    }

    protected $fillable = ['name', 'minutes_secondary_expiration', 'category_id', 'active'];
    public function getExpirationDate(){
        $minutos = $this->minutes_secondary_expiration;
        if ($minutos >= 60) {
            return round($minutos / 60, 1) . ' Horas';
        }

        return $minutos . ' Minutos';
    }

    public function calculateExpirationDate(){
        return Carbon::now()->addMinutes($this->minutes_secondary_expiration);
    }
}
