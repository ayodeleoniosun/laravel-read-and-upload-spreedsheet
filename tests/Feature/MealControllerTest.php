<?php

namespace Tests\Feature;

use App\Http\Models\User;
use Tests\Traits\User as TraitsUser;
use Tests\Traits\Allergy as TraitsAllergy;
use Tests\TestCase;

class MealControllerTest extends TestCase
{
    use TraitsAllergy, TraitsUser;
    
    public function setUp(): void
    {
        parent::setup();
    }

    public function testShowAllMeals()
    {
        $response = $this->json('GET', $this->route("/meals"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $response->assertJsonStructure([
            'status',
            'meals' => [
                '*' => [
                    'id', 'name', 'created_at', 'updated_at',
                    'main_item' => [
                        'id', 'name', 'created_at', 'updated_at'
                    ],
                    'side_items' => [
                        '*' => ['id', 'name', 'created_at', 'updated_at']
                    ]
                ]
            ]
        ]);
    }

    public function testShowSingleMeal()
    {
        $response = $this->json('GET', $this->route("/meals/1"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $response->assertJsonStructure([
            'status',
            'meal' => [
                'id', 'name', 'created_at', 'updated_at',
                'main_item' => [
                    'id', 'name', 'created_at', 'updated_at'
                ],
                'side_items' => [
                    '*' => ['id', 'name', 'created_at', 'updated_at']
                ]
            ]
        ]);
    }

    public function testRecommendMealForMultipleUsers()
    {
        $users = factory(User::class, 3)->create();
        $users = $users->pluck('id')->toArray();
        
        $response = $this->json('POST', $this->route("/meals/recommendations"), ["users" => $users]);
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
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
