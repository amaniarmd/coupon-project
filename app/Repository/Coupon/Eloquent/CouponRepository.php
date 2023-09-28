<?php

namespace App\Repository\Coupon\Eloquent;

use App\Enums\Fields;
use App\Enums\OutputMessages;
use App\Models\Coupon;
use App\Repository\Coupon\Interfaces\CouponInterface;
use App\Repository\Coupon\Interfaces\RuleInterface;
use Carbon\Carbon;

class CouponRepository extends BaseRepository implements CouponInterface
{
    private RuleInterface $ruleRepository;

    public function __construct(Coupon $model, RuleInterface $ruleRepository)
    {
        $this->ruleRepository = $ruleRepository;
        parent::__construct($model);
    }

    public function createCoupon(array $data)
    {
        $couponRuleIds = [];

        foreach ($data[Fields::RULES] as $key => $rule) {
            $ruleModel = $this->ruleRepository->createRule($rule);
            unset($data[Fields::RULES][$key]);
            $couponRuleIds[] = $ruleModel[Fields::ID];
        }

        $data[Fields::CODE] = $this->generateCouponCode();

        return $this->create($data, Fields::RULES, $couponRuleIds);
    }

    private function generateCouponCode($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $code;
    }

    public function apply(array $data)
    {
        $this->check($data);
        $coupon = $this->findCouponByCode($data[Fields::CODE]);

        return $this->ruleRepository->process($coupon, $data[Fields::USER_ID]);
    }

    public function check(array $data)
    {
        $coupon = $this->findCouponByCode($data[Fields::CODE]);
        $this->checkCouponisNotExpiredAndHasQuantity($coupon);

        $couponRules = $coupon[Fields::RULES];

        foreach ($couponRules as $couponRule) {
            $ruleObject = $this->ruleRepository->createRuleObject($couponRule[Fields::RULE_ENUM]);
            $rulesArray = $this->ruleRepository->jsonDecode($couponRule[Fields::RULE_ENTRIES]);

            $ruleObject->validateProcess($rulesArray, $data[Fields::USER_ID]);
        }

        return $this->ruleRepository->jsonResponse(OutputMessages::SUCCESSFUL_CODE_VALIDATION);
    }

    private function findCouponByCode($code)
    {
        return $this->findByAttribute(Fields::CODE, "=", $code);
    }

    private function checkCouponisNotExpiredAndHasQuantity($coupon)
    {
        if (!is_null($coupon->expire_date)) {
            $expireDate = Carbon::parse($coupon->expire_date);

            if (!$expireDate->isFuture()) {
                $this->ruleRepository->jsonErrorResponse(OutputMessages::COUPON_EXPIRED);
            }
        }

        if (!is_null($coupon->quantity)) {
            if ($coupon->quantity < 1) {
                $this->ruleRepository->jsonErrorResponse(OutputMessages::COUPON_IS_FULL);
            }
        }
    }
}
