<?php

namespace App\Enums;

final class OutputMessages
{
    public const INCORRECT_RULE_ENTRIES = "Rule entries are incorrect";
    public const RULE_NOT_FOUND = "Rule id that you entered does not exist";
    public const RULE_CLASS_NOT_FOUND = "Rule has not a defined class";
    public const RECORD_NOT_FOUND = "Record does not exist";
    public const COUPON_CITY_WRONG = "Coupon is not defined for the city of user";
    public const CART_PURCHASE_DATE_NOT_FOUND = "This user has not purchased anything";
    public const PURCHASE_DATE_SOONER_THAN_RULE_DATE = "This user has purchased sooner than the rule date";
    public const SUCCESSFUL_CODE_VALIDATION = ["message"=>"This code is valid for this user"];
    public const COUPON_EXPIRED = "This coupon is expired";
    public const COUPON_IS_FULL = "This coupon's capacity is full";
    public const COUPON_IS_NOT_FOR_YOU = "This coupon is not defined for you";
}
