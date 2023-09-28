<?php

namespace App\Repository\Coupon\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RuleInterface extends EloquentRepositoryInterface
{
    public function createRule(array $rule);
    public function createRuleObject(int $ruleEnum);
    public function process(Model $coupon, $userId);
}
