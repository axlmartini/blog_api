<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class ApiLoginTest extends TestCase
{

    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'test_user@email.com',
            'password' => bcrypt('test_user'),
        ]);

        $payload = [
            'email' => 'test_user@email.com',
            'password' => 'test_user'
        ];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'api_token',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // delete user eventually
        $this->clearAddedData($user);
    }
}
