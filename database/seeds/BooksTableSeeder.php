<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Book;
use App\Category;
use App\Tag;
use App\Supplier;
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
        $suppliers = Supplier::all();
        $authors = Author::all();
        $categories = Category::all();
        for ($i=1; $i <= 10; $i++) {
            $book = Book::create([
                'name' => $faker->name,
                'published_date' => $faker->date('Y-m-d', 'now'),
                'description' => $faker->paragraph(3, true),
                'price' => 1000,
                'pages' => 165,
                'publisher_id' => Publisher::find(rand(1,10))->id,
                'bookSize' => 5,
                'supplier_id' => Supplier::find(rand(1,10))->id
            ]);
            $file = file_get_contents("https://creativebonito.com/wp-content/uploads/2018/07/book-cover-mockup-templates-cover.png");
            $path = '/images/books/' . $i . "/image_1.png";
            Storage::disk('public')->put($path , $file);

            $thumb_file = file_get_contents('https://creativebonito.com/wp-content/uploads/2018/07/book-cover-mockup-templates-cover.png');
            $thumb_path = '/images/books/' . $i . '/thumb_nail.png';
            Storage::disk('public')->put($thumb_path , $thumb_file);

            $book->tags()->sync($tags->random(3));
            $book->suppliers()->sync($suppliers->random(3));
            $book->authors()->sync($authors->random(2));
            $book->categories()->sync($categories->random(2));
        }
    }
}
