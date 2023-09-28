<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $endpoint = '/api/coupons/create';

        $cityRuleData = [
            'result' => $faker->numberBetween(1, 100),
            'is_percent' => true,
            'rules' => [[
                'enum' => 1001,
                'rule_entries' => '{"city": "Arak"}',
            ],]
        ];

        Http::post(url($endpoint), $cityRuleData);

        $timePassedFromLastPurchaseRuleData = [
            'result' => $faker->numberBetween(1, 9) * 1000,
            'rules' => [[
                'enum' => 1002,
                'rule_entries' => '{"start_date": "' . Carbon::now()->subMonth() . '"}',
            ],]
        ];

        Http::post(url($endpoint), $timePassedFromLastPurchaseRuleData);

        $usersGroupRuleData = [
            'result' => $faker->numberBetween(1, 9) * 1000,
            'rules' => [[
                'enum' => 1003,
                'rule_entries' => '{"user_ids": [3,4,5]}',]
            ],
        ];

        Http::post(url($endpoint), $usersGroupRuleData);
    }
}
