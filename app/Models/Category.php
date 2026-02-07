<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function activeTimers()
    {
        return $this->belongsToMany(ActiveTimer::class);
    }

    public function getStylesAttribute(): array
    {
        $name = strtolower($this->name);

        return match (true) {
            str_contains($name, 'caf') => [
                'theme' => 'theme-mccafe',
                'icon' => 'coffee'
            ],
            str_contains($name, 'isla'), str_contains($name, 'postre') => [
                'theme' => 'theme-isla',
                'icon' => 'icecream'
            ],
            str_contains($name, 'serv'), str_contains($name, 'mostrador') => [
                'theme' => 'theme-servicio',
                'icon' => 'service'
            ],
            default => [
                'theme' => 'theme-cocina',
                'icon' => 'burger'
            ],
        };
    }
}

