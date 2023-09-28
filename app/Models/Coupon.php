<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'expire_date', 'quantity', 'is_percent', 'result'
    ];

    public function rules()
    {
        return $this->belongsToMany(Rule::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
