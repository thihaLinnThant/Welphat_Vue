<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
            User::create([
                'name'  => $faker->name,
                'email'=> $faker->name.'@gmail.com',
                'password' => Hash::make('password'),
                'api_token' => Str::random(60),
                'ph_no' => $faker->phoneNumber,
                'address' => $faker->address
            ]);
        }
    }
}
