<?php

use Illuminate\Database\Seeder;
use App\Comment;
use App\Post;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        foreach ($posts as $post) {

            // skip adding comment for post id 3
            if (3 !== $post->id) {
                Comment::insert([
                    [
                        'post_id' => $post->id,
                        'content' => 'Comment content for ' . $post->title,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
        }
    }
}
