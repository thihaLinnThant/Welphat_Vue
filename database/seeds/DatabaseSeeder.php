<?php

use App\Http\Controllers\RatingController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(Category_table_seeder::class);
        // $this->call(TagTableSeeder::class);
        // $this->call(PublisherTableSeeder::class);
        // $this->call(SuppliersTableSeeder::class);
        // $this->call(AuthorTableSeeder::class);
        // $this->call(BooksTableSeeder::class);
        // $this->call(CommentTableSeeder::class);
        // $this->call(AdminTableSeeder::class);
        // $this->call(RatingTableSeeder::class);
        // $this->call(WishTableSeeder::class);
        // $this->call(OrderTableSeeder::class);
        $this->call(AdminNotificationTableSeeder::class);
    }
}
