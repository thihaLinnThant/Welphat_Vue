<?php

use Illuminate\Database\Seeder;
use App\Author;
use Illuminate\Support\Facades\Storage;
class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=1; $i <= 10; $i++) { 
            Author::create([
                "name"  => $faker->name,
                "bio" => $faker->paragraph(3, true)
            ]);            
            // $file = file_get_contents("https://dummyimage.com/400x400/4053b5/f0e8f0");
            // $path = '/images/authors/' . $i . "/image_1.png";
            // Storage::disk('public')->put($path , $file);

            // $thumb_file = file_get_contents('https://dummyimage.com/200x200/4053b5/f0e8f0');
            // $thumb_path = '/images/authors/' . $i . '/thumb_nail.png';
            // Storage::disk('public')->put($thumb_path , $thumb_file);
        }
    }
}
