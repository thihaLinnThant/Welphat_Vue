<?php

use Illuminate\Database\Seeder;
use App\Supplier;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
            Supplier::create([
                "name"  => $faker->word,
                "phno"  => $faker->phoneNumber,
                "address"  => $faker->address
            ]);
        }
    }
}
