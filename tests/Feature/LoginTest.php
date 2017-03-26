<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_i_should_see_the_login_page_only_if_i_am_not_logged_in()
    {
        $this->get('/login')
             ->assertStatus(200);

        $this->signIn()
             ->get('/login')
             ->assertStatus(302);
    }

    public function test_i_should_not_be_logged_in_with_invalid_credentials()
    {
        $user = create('App\User');
        $response = $this->post('/login', ['username' => $user->username, 'password' => 'wrongPassword']);

        while($response->isRedirect()){
            $response = $this->get($response->headers->get('Location'));
        }

        $response->assertSee('Login');
    }

    public function test_i_should_be_logged_in_with_valid_credentials()
    {
        $user = create('App\User');
        $response = $this->post('/login', ['username' => $user->username, 'password' => 'secret']);

        while($response->isRedirect()){
            $response = $this->get($response->headers->get('Location'));
        }

        $response->assertDontSee('Login');
    }
}
