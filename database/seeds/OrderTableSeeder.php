<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Book;
use App\Book_order;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 1; $i <= 10; $i++){
            Order::create([
                'user_id'  => $i,
                'phone_no' => $faker->phoneNumber,
                'address'  => $faker->address,
                'status'   => 'in_progress'
            ]);
            for($y=1; $y <= 3; $y++ ){
                $book = Book::find($y);
                Book_order::create([
                    'order_id' => $i,
                    'book_id' => $y,
                    'book_name' => $book->name,
                    'book_price'=> $book->price
                ]);
            }
        }
    }
}
