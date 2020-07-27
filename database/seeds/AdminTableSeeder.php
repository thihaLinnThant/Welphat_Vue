<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class AdminTableSeeder extends Seeder
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
            Admin::create([
                'name' => $faker->name,
                'email' => $faker->name.'@gmail.com',
                'password' => Hash::make('password'),
                'api_token' => Str::random(60),
            ]);
        }
    }
}
