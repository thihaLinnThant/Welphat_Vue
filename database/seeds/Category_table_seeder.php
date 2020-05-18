<?php

use Illuminate\Database\Seeder;
use App\Category;

class Category_table_seeder extends Seeder
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
            Category::create([
                "name"  => $faker->word
            ]);    
        }
    }
}
