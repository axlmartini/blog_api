<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use App\User;
use App\Post;

class PostTest extends TestCase
{
    public function testsGetPostsUnauthorized()
    {
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $this->json('GET', '/api/posts/' . $post->id, [])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        $this->clearAddedData($post);
    }

    public function testsPostsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ];

        $response = $this->json('POST', '/api/posts', $payload, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'created_at',
                'updated_at',
            ]);

        $createdPost = Post::find(json_decode($response->getContent())->id);
        $this->clearAddedData($createdPost);
        $this->clearAddedData($user);
    }

    public function testsPostsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $payload = [
            'title' => 'Sample Update Title',
            'content' => 'Sample Update Content',
        ];

        $this->json('PUT', '/api/posts/' . $post->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'created_at',
                'updated_at',
            ]);

        $this->clearAddedData($post);
        $this->clearAddedData($user);
    }

    public function testsPostsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $this->json('DELETE', '/api/posts/' . $post->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Record has been deleted.'
            ]);

        $this->clearAddedData($user);
    }

    public function testsPostsWithCommentNotDeleted()
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

        $this->json('DELETE', '/api/posts/' . $post->id, [], $headers)
            ->assertStatus(400)
            ->assertJson([
                'message' => 'Cannot delete record. Associated with Comment.'
            ]);

        $this->clearAddedData($user);
        $this->clearAddedData($comment);
        $this->clearAddedData($post);
    }

    public function testPostsAreListedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Sample Title',
            'content' => 'Sample Content',
        ]);

        $post2 = factory(Post::class)->create([
            'title' => 'Sample Title 2',
            'content' => 'Sample Content 2',
        ]);

        $comment = factory(Comment::class)->create([
            'content' => 'Sample Comment',
            'post_id' => $post2->id,
        ]);

        $this->json('GET', '/api/posts', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'content',
                    'created_at',
                    'updated_at',
                    'comments',
                ],
            ]);

        $this->clearAddedData($user);
        $this->clearAddedData($comment);
        $this->clearAddedData($post);
        $this->clearAddedData($post2);
    }
}
