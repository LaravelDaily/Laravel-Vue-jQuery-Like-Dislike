<?php

use App\Post;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Post::create([
                'title'     => $faker->sentence,
                'full_text' => $faker->paragraph,
            ]);
        }
    }
}
