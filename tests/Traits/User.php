<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;

trait User
{
    use WithFaker;

    public function registerUser($emailAddress = null)
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $emailAddress ?? $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'phone_number' => '080'.rand(111111111, 999999999),
        ];

        return $this->json('POST', $this->route("/users/register"), $data);
    }
}
