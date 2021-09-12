<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::insert([
            [
                'title' => 'Post 1',
                'content' => 'Post 1 Content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Post 2',
                'content' => 'Post 2 Content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Post 3',
                'content' => 'Post 3 Content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Post 4',
                'content' => 'Post 4 Content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Post 5',
                'content' => 'Post 5 Content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
