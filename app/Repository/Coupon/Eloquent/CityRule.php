<?php

namespace App\Repository\Coupon\Eloquent;

use App\Enums\OutputMessages;
use App\Enums\Fields;
use App\Repository\Coupon\Interfaces\AbstractRule;
use App\Repository\Coupon\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;


class CityRule implements AbstractRule
{
    public const RULE_ENUM = 1001;

    public function validateProcess(array $rules, $userId)
    {
        $userRepository = App::make(UserInterface::class);
        $user = $userRepository->find($userId);

        if ($user[Fields::CITY] == $rules[Fields::CITY]) {
            return true;
        }

        $userRepository->jsonErrorResponse(OutputMessages::COUPON_CITY_WRONG, Response::HTTP_BAD_REQUEST);
    }
}
