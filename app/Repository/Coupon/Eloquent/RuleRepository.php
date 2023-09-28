<?php

namespace App\Repository\Coupon\Eloquent;

use App\Enums\Rules;
use App\Enums\Fields;
use App\Enums\OutputMessages;
use App\Models\Rule;
use App\Repository\Coupon\Interfaces\CouponInterface;
use App\Repository\Coupon\Interfaces\RuleInterface;
use App\Repository\Coupon\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class RuleRepository extends BaseRepository implements RuleInterface
{
    public function __construct(Rule $model)
    {
        parent::__construct($model);
    }

    public function createRule($rule)
    {
        $this->validateRuleExistence($rule[Fields::ENUM]);

        if (!array_key_exists(Fields::RULE_ENTRIES, Rules::RULES[$rule[Fields::ENUM]])) {
            unset($rule[Fields::RULE_ENTRIES]);
        } else {
            $this->validateJson(Rules::RULES[$rule[Fields::ENUM]][Fields::RULE_ENTRIES], $rule[Fields::RULE_ENTRIES]);
        }

        $finalRule = $this->transformRuleKeys($rule);

        return $this->create($finalRule);
    }

    private function validateRuleExistence($ruleEnum): void
    {
        if (!array_key_exists($ruleEnum, Rules::RULES)) {
            $this->jsonErrorResponse(OutputMessages::RULE_NOT_FOUND);
        }
    }

    private function validateJson($rules, $ruleEntries)
    {
        $ruleEntries = $this->jsonDecode($ruleEntries);

        if ($ruleEntries === null && json_last_error() !== JSON_ERROR_NONE) {
            $this->jsonErrorResponse(OutputMessages::INCORRECT_RULE_ENTRIES);
        }

        $validator = Validator::make($ruleEntries, $rules);

        if ($validator->fails()) {
            $this->jsonErrorResponse($validator->errors());
        }

        return true;
    }

    private function transformRuleKeys($rule)
    {
        foreach ($rule as $key => $value) {
            if ($key === Fields::ENUM) {
                $rule[Fields::RULE_ENUM] = $value;
                unset($rule[Fields::ENUM]);
            }
        }

        return $rule;
    }

    public function createRuleObject(int $ruleEnum)
    {
        $this->validateRuleExistence($ruleEnum);

        if ($ruleEnum === CityRule::RULE_ENUM) {
            return new CityRule();
        }
        if ($ruleEnum === PurchaseTimeRule::RULE_ENUM) {
            return new PurchaseTimeRule();
        }
        if ($ruleEnum === UsersGroupRule::RULE_ENUM) {
            return new UsersGroupRule();
        }


        $this->jsonErrorResponse(OutputMessages::RULE_CLASS_NOT_FOUND);
    }

    public function process(Model $coupon, $userId)
    {
        $userRepository = App::make(UserInterface::class);
        $user = $userRepository->find($userId);
        $cart = $user[Fields::CART];
        $cart[Fields::DISCOUNTED_AMOUNT] = $this->calculateDiscountedAmount($cart[Fields::ORIGINAL_AMOUNT], $coupon[Fields::IS_PERCENT], $coupon[Fields::RESULT]);
        $cart[Fields::COUPON_ID] = $coupon[Fields::ID];
        $cart->save();

        $couponRepository = App::make(CouponInterface::class);
        $couponRepository->updateAttribute($coupon, Fields::QUANTITY, $coupon[Fields::QUANTITY] -1);

        return $cart;
    }

    private function calculateDiscountedAmount($originalAmount, $isPercent, $result)
    {
        if ($isPercent) {
            return $originalAmount - ($originalAmount * $result / 100);
        }

        return $originalAmount - $result;
    }
}
