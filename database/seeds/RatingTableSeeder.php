<?php

use Illuminate\Database\Seeder;
use App\Rating;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        for($i = 1; $i <= 10; $i++){
            for($y = 1; $y <=10; $y++){                
                $num = rand(1,5);
                Rating::create([
                    'rating' => $num,
                    'book_id' => $y,
                    'user_id' => $i
                ]);
            }
        }
    }
}
