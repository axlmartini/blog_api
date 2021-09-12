<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Post;
use App\Comment;

class CommentTest extends TestCase
{
    public function testsGetCommentsUnauthorized()
    {
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'Sample Comment',
            'post_id' => $post->id,
        ]);

        $this->json('GET', '/api/posts/' . $post->id, [])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        $this->clearAddedData($comment);
        $this->clearAddedData($post);
    }

    public function testsCommentsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $payload = [
            'content' => 'Sample Comment',
            'post_id' => $post->id,
        ];

        $response = $this->json('POST', '/api/comments', $payload, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'post_id',
                'content',
                'created_at',
                'updated_at',
            ]);

        $createdComment = Comment::find(json_decode($response->getContent())->id);
        $this->clearAddedData($createdComment);
        $this->clearAddedData($post);
        $this->clearAddedData($user);
    }

    public function testsCommentsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'Sample Comment',
            'post_id' => $post->id,
        ]);

        $payload = [
            'content' => 'Sample Comment Update',
            'post_id' => $post->id,
        ];

        $this->json('PUT', '/api/comments/' . $comment->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'post_id',
                'content',
                'created_at',
                'updated_at',
            ]);

        $this->clearAddedData($comment);
        $this->clearAddedData($post);
        $this->clearAddedData($user);
    }

    public function testsCommentsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'Sample Comment',
            'post_id' => $post->id,
        ]);

        $this->json('DELETE', '/api/comments/' . $comment->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Record has been deleted.'
            ]);

        $this->clearAddedData($user);
        $this->clearAddedData($post);
    }

    public function testCommentsListedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'Sample Comment',
            'post_id' => $post->id,
        ]);

        $comment2 = factory(Comment::class)->create([
            'content' => 'Sample Comment 2',
            'post_id' => $post->id,
        ]);

        $this->json('GET', '/api/comments', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'post_id',
                    'content',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->clearAddedData($user);
        $this->clearAddedData($comment);
        $this->clearAddedData($comment2);
        $this->clearAddedData($post);
    }
}
