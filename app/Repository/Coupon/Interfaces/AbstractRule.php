<?php

namespace App\Repository\Coupon\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface AbstractRule
{
    public function validateProcess(array $rules, $userId);
}
