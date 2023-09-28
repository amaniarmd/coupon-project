<?php

namespace App\Repository\Coupon\Interfaces;

interface CouponInterface extends EloquentRepositoryInterface
{
    public function createCoupon(array $data);
    public function check(array $data);
    public function apply(array $data);
}
