<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $password = Hash::make('api_user');
        $token = Str::random(20);

        User::insert([
            [
                'email' => 'api_user@email.com',
                'password' => $password,
                'api_token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
