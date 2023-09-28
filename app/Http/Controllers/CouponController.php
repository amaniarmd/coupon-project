<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\CheckCouponRequest;
use App\Http\Requests\CreateCouponRequest;
use App\Repository\Coupon\Interfaces\CouponInterface;

class CouponController extends Controller
{
    private CouponInterface $couponRepository;

    public function __construct(CouponInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function create(CreateCouponRequest $request)
    {
        return $this->couponRepository->createCoupon($request->all());
    }

    public function check(CheckCouponRequest $request)
    {
        return $this->couponRepository->check($request->all());
    }

    public function apply(ApplyCouponRequest $request)
    {
        return $this->couponRepository->apply($request->all());
    }
}
