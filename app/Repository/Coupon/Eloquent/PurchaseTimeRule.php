<?php

namespace App\Repository\Coupon\Eloquent;

use App\Enums\OutputMessages;
use App\Enums\Fields;
use App\Repository\Coupon\Interfaces\AbstractRule;
use App\Repository\Coupon\Interfaces\UserInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;


class PurchaseTimeRule implements AbstractRule
{
    public const RULE_ENUM = 1002;

    public function validateProcess(array $rules, $userId)
    {
        $userRepository = App::make(UserInterface::class);
        $user = $userRepository->find($userId);

        $start_date = Carbon::parse($rules[Fields::START_DATE]);

        if (is_null($user[Fields::LAST_PURCHASE_DATE])) {
            $userRepository->jsonErrorResponse(OutputMessages::CART_PURCHASE_DATE_NOT_FOUND);
        }

        $purchase_date = Carbon::parse($user[Fields::LAST_PURCHASE_DATE]);

        if ($purchase_date->isBefore($start_date)) {
            return true;
        }

        $userRepository->jsonErrorResponse(OutputMessages::PURCHASE_DATE_SOONER_THAN_RULE_DATE, Response::HTTP_BAD_REQUEST);
    }
}
