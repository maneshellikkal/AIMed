<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_i_should_see_the_register_page_only_if_i_am_not_logged_in ()
    {
        $this->get('/register')
             ->assertStatus(200);

        $this->actingAs(factory(User::class)->create())
             ->get('/register')
             ->assertStatus(302);
    }

    public function test_i_should_be_on_home_page_after_registering()
    {
        $user     = factory(User::class)->make();
        $response = $this->register($user);
        $response->assertRedirect('/');
    }

    public function test_i_should_see_user_in_database_after_registering ()
    {
        $user = factory(User::class)->make();
        $this->register($user);
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    public function register ($user)
    {
        return $this->post('/register', [
            'name'                  => $user->name,
            'username'              => $user->username,
            'email'                 => $user->email,
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ]);
    }
}
