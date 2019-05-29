<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200)->assertSee('login');
    }

    /*public function testAuthenticatedUser()
    {
        $user = create('App\User', [
            "email" => "test@mail.com",
            "username" => "test"
        ]);

        $this->get('/login')->assertSee('Login');

        $credentials = [
            "username" => "test",
            "password" => "secret"
        ];

        $response = $this->post('/login', $credentials);
        $response->assertRedirect('/');
        $this->assertCredentials($credentials);
    }

    public function testinvalidCredentials()
    {
        $user = create('App\User', [
            "email" => "test@mail.com",
            "username" => "test"
        ]);
        $credentials = [
            "username" => "test",
            "password" => "secret"
        ];

        $this->assertInvalidCredentials($credentials);
    }

    public function testUsernameRequired()
    {
        $user = create('App\User');
        $credentials = [
            "username" => null,
            "password" => "secret"
        ];

        $response = $this->from('/login')->post('/login', $credentials);
        $response->assertRedirect('/login')->assertSessionHasErrors([
            'username' => 'The username field is required.',
        ]);
    }

    public function testPasswordRequired()
    {
        $user = create('App\User', [
            'email' => 'test@mail.com',
            'username' => 'test'
        ]);
        $credentials = [
            "username" => "test",
            "password" => null
        ];

        $response = $this->from('/login')->post('/login', $credentials);
        $response->assertRedirect('/login')->assertSessionHasErrors([
            'password' => 'The password field is required.',
        ]);
    }*/
}
