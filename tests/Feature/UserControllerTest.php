<?php

namespace Tests\Feature;

use Tests\Traits\User as TraitsUser;
use Tests\Traits\Allergy as TraitsAllergy;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use TraitsUser, TraitsAllergy;

    public function setUp(): void
    {
        parent::setup();
    }

    public function testRequiredDetailsNotPresentInAccountCreation()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'password' => 'secret',
            'phone_number' => ''
        ];
        
        $response = $this->json('POST', $this->route("/users/register"), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json('message'), 'The given data was invalid.');
        $this->assertEquals($response->json('errors.phone_number')[0], 'Phone number is required');
    }

    public function testPasswordMinimumCharacters()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'password' => 'secre',
            'phone_number' => '080'.rand(111111111, 999999999),
        ];

        $response = $this->json('POST', $this->route("/users/register"), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json('message'), 'The given data was invalid.');
        $this->assertEquals($response->json('errors.password')[0], 'Password must not be less than 6 characters');
    }

    public function testPhoneNumberMinimumCharacters()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'password' => 'secret',
            'phone_number' => '080'.rand(111, 999),
        ];

        $response = $this->json('POST', $this->route("/users/register"), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json('message'), 'The given data was invalid.');
        $this->assertEquals($response->json('errors.phone_number')[0], 'Phone number should not be less than 10 characters');
    }

    public function testPhoneNumberMaximumCharacters()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'phone_number' => '080'.rand(11111111111111, 99999999999999),
        ];

        $response = $this->json('POST', $this->route("/users/register"), $data);
        $response->assertStatus(422);
        $this->assertEquals($response->json('message'), 'The given data was invalid.');
        $this->assertEquals($response->json('errors.phone_number')[0], 'Phone number should not be more than 15 characters');
    }

    public function testEmailAddressExist()
    {
        $user = $this->registerUser();
        $emailAddress = $user->getData()->user->email_address;
        $response = $this->registerUser($emailAddress);

        $response->assertStatus(422);
        $this->assertEquals($response->json('message'), 'The given data was invalid.');
        $this->assertEquals($response->json('errors.email_address')[0], 'Email address already exist');
    }

    public function testRegistrationSuccessful()
    {
        $response = $this->registerUser();
        $response->assertStatus(201);
        $response->assertJsonStructure(
            [
                'status',
                'user',
                'message'
            ]
        );

        $this->assertEquals($response->json('status'), 'success');
        $this->assertEquals($response->json('message'), 'Registration successful.');
    }

    public function testIncorrectLoginDetails()
    {
        $data = [
            'email_address' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
        ];

        $response = $this->json('POST', $this->route("/users/login"), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->json('status'), 'error');
        $this->assertEquals($response->json('message'), 'Incorrect login credentials. Try again.');
    }

    public function testLoginSuccessful()
    {
        $user = $this->registerUser();
        
        $data = [
            'email_address' => $user->getData()->user->email_address,
            'password' => 'secret',
        ];
        
        $response = $this->json('POST', $this->route("/users/login"), $data);
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $this->assertEquals($response->json('message'), 'Login successful');
    }

    public function testMealRecommendations()
    {
        $user = $this->registerUser();
        $token = $user->json('user.bearer_token');
        $this->pickAllergy($token);

        $response = $this->req($token)->json('GET', $this->route("/users/meals/recommendations"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $response->assertJsonStructure([
            'status',
            'recommendations' => [
                '*' => [
                    'user' => ['id', 'first_name', 'last_name', 'email_address', 'phone_number', 'created_at', 'updated_at'],
                    'recommendations' => [
                        '*' => ['id', 'name', 'created_at', 'updated_at']
                    ]
                ]
            ]
        ]);
    }

}
