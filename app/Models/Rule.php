<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
      'rule_entries', 'rule_enum'
    ];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }
}
