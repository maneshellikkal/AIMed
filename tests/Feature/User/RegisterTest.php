<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function authenticated_users_may_not_create_account ()
    {
        $this->get('/register')
             ->assertStatus(200);

        $this->signIn()
             ->get('/register')
             ->assertStatus(302);
    }

    /** @test */
    public function confirmation_message_should_be_displayed_on_registration ()
    {
        $this->register()
             ->assertSessionHas('info', 'You need to confirm your email address before logging in. We have sent you an email.');
    }

    /** @test */
    function registration_requires_valid_name ()
    {
        $this->register(['name' => null])
             ->assertSessionHasErrors('name');

        $this->register(['name' => str_random(300)])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    function registration_requires_valid_unique_username ()
    {
        $this->register(['username' => null])
             ->assertSessionHasErrors('username');

        $this->register(['username' => str_random(3)])
             ->assertSessionHasErrors('username');

        $this->register(['username' => str_random(300)])
             ->assertSessionHasErrors('username');

        $user = create('App\User');
        $this->register(['username' => $user->username])
             ->assertSessionHasErrors('username');
    }

    /** @test */
    function registration_requires_valid_username ()
    {
        $this->register(['email' => null])
             ->assertSessionHasErrors('email');

        $this->register(['email' => str_random(10)])
             ->assertSessionHasErrors('email');

        $user = create('App\User');
        $this->register(['email' => $user->email])
             ->assertSessionHasErrors('email');
    }

    /** @test */
    function registration_requires_valid_password ()
    {
        $this->register([], '')
             ->assertSessionHasErrors('password');

        $this->register([], str_random(5))
             ->assertSessionHasErrors('password');
    }

    /** @test */
    function password_confirmation_must_match ()
    {
        $this->register([], 'anotherPassword')
             ->assertSessionHasErrors('password');

        $this->register([], str_random(5))
             ->assertSessionHasErrors('password');
    }

    /** @test */
    public function newsletter_should_be_subscribed_on_registration ()
    {
        $email = 'test@example.com';
        $this->register(['email' => $email]);

        $user = User::whereEmail($email)->first();

        $this->assertEquals(1, $user->newsletter);
    }

    protected function register($overrides = [], $password = 'secret')
    {
        $user = make('App\User', $overrides);

        return $this->post('/register', $user->toArray() + ['password' => $password, 'password_confirmation' => 'secret']);
    }
}
