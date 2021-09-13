<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations, CreatesApplication;
    public $baseURL;
    protected $user;

    public function setup() : void
    {
        parent::setUp();
        $this->baseURL = sprintf('http://%s/api/v1', config('app.domain'));
        $this->faker = \Faker\Factory::create();
    }

    public function route($route) : string
    {
        return sprintf('%s%s', $this->baseURL, $route);
    }
}
