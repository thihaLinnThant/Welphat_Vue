<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Book;
use App\Category;
use App\Tag;
use App\Author;
use App\Publisher;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $tags = Tag::all();
        $authors = Author::all();
        $categories = Category::all();
        for ($i=1; $i <= 10; $i++) {            
            $book = Book::create([
                'name' => $faker->name,                
                'published_date' => $faker->date('Y-m-d', 'now'),
                'description' => $faker->paragraph(3, true),
                'price' => 1000,
                'publisher_id' => Publisher::find(rand(1,10))->id
            ]);
            $file = file_get_contents("https://dummyimage.com/300x400/4053b5/f0e8f0");
            $path = '/images/books/' . $i . "/image_1.png";
            Storage::disk('public')->put($path , $file);

            $thumb_file = file_get_contents('https://dummyimage.com/150x200/4053b5/f0e8f0');
            $thumb_path = '/images/books/' . $i . '/thumb_nail.png';
            Storage::disk('public')->put($thumb_path , $thumb_file);

            $book->tags()->sync($tags->random(3));
            $book->authors()->sync($authors->random(2));
            $book->categories()->sync($categories->random(2));
        }
    }
}
