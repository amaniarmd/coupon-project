<?php

namespace App\Enums;

final class Rules
{
    public const RULES = [
        1001 => [Fields::RULE_NAME => 'cityRule', Fields::RULE_ENTRIES => ['city' => 'required|string|max:255']],
        1002 => [Fields::RULE_NAME => 'timePassedFromLastPurchaseRule', Fields::RULE_ENTRIES => ['start_date' => 'required|date']],
        1003 => [Fields::RULE_NAME => 'usersGroupRule', Fields::RULE_ENTRIES => ['user_ids' => 'required|array', 'user_ids.*' => 'integer|exists:users,id']],
    ];
}
