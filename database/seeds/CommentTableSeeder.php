<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Book;
use App\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $num = rand(1, 10);
            $user = User::find($num);

            $book = Book::find($num);
            Comment::create([
                "user_id" => $user->id,
                "book_id" => $book->id,
                "comment_text" => $faker->paragraph(1, true)
            ]);
        }
    }
}
