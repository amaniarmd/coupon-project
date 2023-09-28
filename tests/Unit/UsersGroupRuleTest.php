<?php

namespace Tests\Unit;

use App\Enums\Fields;
use App\Models\User;
use Faker\Factory as Faker;
use Tests\TestCase;

class UsersGroupRuleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_if_coupon_can_be_created_for_users_group(): void
    {
        $faker = Faker::create();
        $userIds = [];
        $endpoint = '/api/coupons/create';

        for ($i = 0; $i < 3; $i++) {
            $userData = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt($faker->password),
                'city' => $faker->city
            ];

            $user = User::create($userData);
            $userIds[] = $user[Fields::ID];
        }

        $usersGroupRuleData = [
            'result' => $faker->numberBetween(1, 9) * 1000,
            'rules' => [[
                'enum' => 1003,
                'rule_entries' => '{"user_ids": [' . implode(', ', $userIds) . ']}',
            ]],
        ];

        $response = $this->post($endpoint, $usersGroupRuleData);

        $response->assertStatus(201);
    }
}
