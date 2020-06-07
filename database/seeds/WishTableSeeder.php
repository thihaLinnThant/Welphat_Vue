<?php

use Illuminate\Database\Seeder;
use App\Wish;
use App\Book;

class WishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++ ){
            $num = 0;
            $temp = $num;
            for($y = 1; $y <= 3; $y++ ){
                $num = rand(1,10);
                if($num != $temp){
                    $book = Book::find($num);
                    Wish::create([
                        'user_id' => $i,
                        'book_id' => $num,
                        'book_name' => $book->name
                    ]);
                    $temp = $num;
                }else {
                    $num = rand(1,10);
                    $y--;
                }
            }
            
        }
    }
}
