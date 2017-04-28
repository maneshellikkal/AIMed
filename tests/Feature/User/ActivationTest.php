<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\LoginController;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MailTracking;
use Tests\TestCase;
use Mockery;

class ActivationTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, MailTracking;
    
    /** @test */
    public function authenticated_users_may_not_verify_account ()
    {

        $this->get('/activation/test')
             ->assertStatus(404);

        $this->signIn()
             ->get('/activation/test')
             ->assertStatus(302);
    }

    /** @test */
    public function activation_token_should_be_sent_during_login ()
    {
        $user     = create('App\User', ['activated' => false]);

        $response = $this->post('/login',
            [
                'username' => $user->username,
                'password' => 'secret'
            ]
        );

        $response->assertSessionHas('info', 'You need to confirm your email address before logging in. We have sent you an email.');
        $this->assertEmailWasSent();
        $this->assertEmailsSentCount(1);
        $this->assertEmailTo($user->email);
    }

    /** @test */
    public function activation_token_should_be_sent_during_registration ()
    {
        $user = make('App\User');

        $response = $this->post('/register', [
            'name'                  => $user->name,
            'username'              => $user->username,
            'email'                 => $user->email,
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertSessionHas('info', 'You need to confirm your email address before logging in. We have sent you an email.');
        $this->assertEmailWasSent();
        $this->assertEmailsSentCount(1);
        $this->assertEmailTo($user->email);
    }

    /** @test */
    public function valid_token_should_verify_account ()
    {
        $activation = create('App\Activation');
        $email = $activation->user->email;

        $this->get('/activation/'. $activation->token)
             ->assertSessionHas('success', 'Your e-mail has been verified.');

        $this->assertDatabaseHas('users', ['email' => $email, 'activated' => true]);
    }

    /** @test */
    public function expired_tokens_should_not_verify_account ()
    {
        $activation = create('App\Activation', ['created_at' => Carbon::now()->subHours(config('settings.user.activation.valid_hours') + 1)]);
        $email = $activation->user->email;

        $this->get('/activation/'. $activation->token)
             ->assertSessionMissing('success', 'Your e-mail has been verified.');

        $this->assertDatabaseHas('users', ['email' => $email, 'activated' => false]);
    }
}
