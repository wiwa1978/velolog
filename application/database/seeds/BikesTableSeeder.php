<?php

use App\Bike;
use Illuminate\Database\Seeder;

class BikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bike::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Bike::create([
                'name' => $faker->userName,
                'make' => $faker->safeColorName,
                'model' => $faker->hexcolor
            ]);
        }
    }
}
