<?php

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
        // creates 3 users using the user factory
        factory(App\User ::class, 3)->create();

        // creates 50 posts using the post factory
        factory(App\Post ::class, 50)->create();
    }
}
