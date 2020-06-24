<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Book;
use App\Book_order;
use App\User;

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

        $random_num = 0;
        $new_random = 0;

        for($i = 1; $i <= 10; $i++){
            $user = User::find($i);
            Order::create([
                'user_id'  => $user->id,
                'user_name'=> $user->name,
                'phone_no' => $faker->phoneNumber,
                'address'  => $faker->address,
                'status'   => 'code-3(in_progress)'
            ]);
            for($y=1; $y <= 3; $y++ ){
                do{
                    $new_random = rand(1,10);
                }while($random_num == $new_random);

                $random_num = $new_random;

                $book = Book::find($random_num);
                Book_order::create([
                    'order_id' => $i,
                    'book_id' => $book->id,
                    'book_name' => $book->name,
                    'qty' => rand(1,4),
                    'book_price'=> $book->price
                ]);
            }
        }
    }
}
