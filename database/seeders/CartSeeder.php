<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('carts')->insert([
            'original_amount' => $faker->numberBetween(1,9)*10000,
            'user_id' => 1
        ]);

        DB::table('carts')->insert([
            'original_amount' => $faker->numberBetween(1,9)*10000,
            'user_id' => 2,
        ]);
    }
}
