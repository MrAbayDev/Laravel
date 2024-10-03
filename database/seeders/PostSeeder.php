<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Testing\Fakes\Fake;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('ads')->insert([
            'title' => $faker->sentence(5),
            'address' => $faker->address,
            'price' => $faker->numberBetween(100, 1000),
            'rooms' => $faker->numberBetween(1, 5),
            'square' => $faker->numberBetween(1, 5),
            'description' => $faker->paragraph,
            'user_id' => 1,
            'branch_id' => 1,
            'status_id' => 1,
        ]);
        Ad::factory()
        ->count(50)
            ->create();
    }
}
