<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;
use Tests\Traits\User as TraitsUser;
use Tests\Traits\Meal as TraitsMeal;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations, CreatesApplication, TraitsUser, TraitsMeal;
    public $baseURL;
    protected $user;

    public function setup() : void
    {
        parent::setUp();
        $this->baseURL = sprintf('http://%s/api/v1', env('APP_DOMAIN'));
        $this->faker = \Faker\Factory::create();
        $this->seedMeals();
    }

    public function route($route) : string
    {
        return sprintf('%s%s', $this->baseURL, $route);
    }

    public function req($token = null)
    {
        $this->user = $this->registerUser();
        $userToken = $token ?? $this->user->getData()->user->bearer_token;
        
        return $this->withHeaders(
            [
                'Authorization' => 'Bearer '.$userToken,
                'Accept' => 'application/json'
            ]
        );
    }
}
