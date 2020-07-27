<?php

use Illuminate\Database\Seeder;
use App\AdminNotification;
use Faker\Factory;

class AdminNotificationTableSeeder extends Seeder
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
            AdminNotification::create([
                'noti_type' => 'admin_action',
                'message'   => 'This is a dummy notification(category)',
                'committer_id' => $i,
                'committer_type' => 'App\Admin',
                'seen_by'   => '',
                'committed_item_id' => $i,
                'committed_item_type' => 'App\Category',
            ]);
        }
    }
}
