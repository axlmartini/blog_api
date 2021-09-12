<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'email' => 'tester_user_reg@mail.com',
            'password' => 'tester_user_reg',
            'password_confirmation' => 'tester_user_reg',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'api_token',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // delete eventually
        $registeredUser = User::firstWhere('email', 'tester_user_reg@mail.com');
        $this->clearAddedData($registeredUser);
    }

    public function testsRequiresPasswordEmail()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'email' => 'tester_user_reg@mail.com',
            'password' => 'tester_user_reg',
            'password_confirmation' => 'reg_user_tester',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => ['The password confirmation does not match.'],
                ]
            ]);
    }
}
