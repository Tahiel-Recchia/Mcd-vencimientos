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



}
