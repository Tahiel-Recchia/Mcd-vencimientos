<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\ActiveTimer;
class Product extends Model
{
    use HasFactory;

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
