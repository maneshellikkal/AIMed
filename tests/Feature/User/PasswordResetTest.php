<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MailTracking;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, MailTracking;

    /** @test */
    public function authenticated_users_should_not_be_allowed_to_request_reset_token ()
    {
        $this->get('/password/reset')
             ->assertSee('Reset Password');

        $this->signIn()
             ->get('/password/reset')
             ->assertRedirect('/');
    }

    /** @test */
    public function authenticated_users_should_not_be_allowed_to_reset_password ()
    {
        $this->get('/password/reset/token')
             ->assertSee('Reset Password');

        $this->signIn()
             ->get('/password/reset/token')
             ->assertRedirect('/');
    }

    /** @test */
    public function valid_email_should_be_provided ()
    {
        $this->post('/password/email', ['email' => 'test@example.com'])
             ->assertSessionHasErrors();
    }

    /** @test */
    public function valid_emails_should_receive_tokens ()
    {
        $user = create('App\User');

        $this->post('/password/email', ['email' => $user->email])
             ->assertSessionHas('status', 'We have e-mailed your password reset link!');

        $this->assertEmailWasSent();
        $this->assertEmailsSentCount(1);
        $this->assertEmailTo($user->email);
    }

    /** @test */
    public function valid_tokens_should_reset_password ()
    {
        $user = create('App\User');
        $password = $user->password;
        $token = \Password::broker()->createToken($user);

        $this->reset($token, $user->email);

        $user = User::find($user->id);

        $this->assertNotEquals($user->password, $password);
    }

    /** @test */
    public function password_must_be_confirmed ()
    {
        $user = create('App\User');
        $password = $user->password;
        $token = \Password::broker()->createToken($user);

        $this->reset($token, $user->email, ['password' => 'newPassword'])
             ->assertSessionHasErrors();

        $user = User::find($user->id);

        $this->assertEquals($user->password, $password);
    }

    /** @test */
    public function invalid_tokens_should_not_reset_password ()
    {
        $user = create('App\User');
        $password = $user->password;

        $this->reset(str_random(64), $user->email)
             ->assertSessionHasErrors();

        $user = User::find($user->id);

        $this->assertEquals($user->password, $password);
    }

    protected function reset($token, $email, $overrides = [])
    {
        $data = [
            'token' => $token,
            'email' => $email,
            'password' => $overrides['password'] ?? 'secret',
            'password_confirmation' => $overrides['password_confirmation'] ?? 'secret',
        ] + $overrides;

        return $this->post('/password/reset', $data);
    }
}
