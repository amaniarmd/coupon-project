<?php

namespace App\Repository\Coupon\Eloquent;

use App\Enums\Fields;
use App\Enums\OutputMessages;
use App\Repository\Coupon\Interfaces\AbstractRule;
use App\Repository\Coupon\Interfaces\UserInterface;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;


class UsersGroupRule implements AbstractRule
{
    public const RULE_ENUM = 1003;

    public function validateProcess(array $rules, $userId)
    {
        $userRepository = App::make(UserInterface::class);

        if (in_array($userId, $rules['user_ids'])) {
            return true;
        }

        $userRepository->jsonErrorResponse(OutputMessages::COUPON_IS_NOT_FOR_YOU, Response::HTTP_BAD_REQUEST);
    }
}
