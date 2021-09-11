<?php

namespace Tests\Feature;

use Tests\Traits\User as TraitsUser;
use Tests\TestCase;
use Tests\Traits\Allergy as TraitsAllergy;
class AllergyControllerTest extends TestCase
{
    use TraitsAllergy, TraitsUser;

    public function setUp(): void
    {
        parent::setup();
    }

    public function testPickAllergyFailure()
    {
        $response = $this->req()->json('POST', $this->route("/allergies"));
        $response->assertStatus(422);
        $this->assertEquals($response->json('message'), 'The given data was invalid.');
        $this->assertEquals($response->json('errors.allergies')[0], 'Select at least one allergy');
    }

    public function testPickAllergySuccessful()
    {
        $response = $this->pickAllergy();
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'status',
            'user_allergies',
            'message'
        ]);
    }

    public function testShowUserAllergies()
    {
        $user = $this->registerUser();
        $token = $user->json('user.bearer_token');
        $this->pickAllergy($token);
        
        $response = $this->req($token)->json('GET', $this->route("/allergies"));
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $response->assertJsonStructure([
            'status',
            'allergies'
        ]);
    }
}
