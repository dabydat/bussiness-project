<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use WithFaker;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AuthenticationController();
    }

    public function testSignUp()
    {
        $request = SignUpRequest::create('/api/auth/v1/signUp', 'POST', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '12345678',
            'phone_number' => '1234567890',
            'local_number' => '1234567890'
        ]);

        $response = $this->controller->signUp($request);
        $this->assertEquals(201, $response->status());
    }

    public function testSignIn()
    {
        $request = SignInRequest::create('/api/auth/v1/signIn', 'POST', [
            'email' => 'bussiness_project_user@example.com',
            'password' => '12345678'
        ]);

        $response = $this->controller->signIn($request);
        $this->assertEquals(200, $response->status());
    }
}
