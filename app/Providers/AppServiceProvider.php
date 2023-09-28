<?php

namespace App\Providers;

use App\Repository\Coupon\Eloquent\CouponRepository;
use App\Repository\Coupon\Eloquent\RuleRepository;
use App\Repository\Coupon\Eloquent\UserRepository;
use App\Repository\Coupon\Interfaces\CouponInterface;
use App\Repository\Coupon\Interfaces\RuleInterface;
use App\Repository\Coupon\Interfaces\UserInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CouponInterface::class, CouponRepository::class);
        $this->app->bind(RuleInterface::class, RuleRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
