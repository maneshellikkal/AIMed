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

    public function test_i_should_see_the_password_reminder_page_only_if_i_am_not_logged_in ()
    {
        $this->get('/password/reset')
             ->assertSee('Reset Password');

        $this->actingAs(factory(User::class)->create())
             ->get('/password/reset')
             ->assertRedirect('/home');
    }

    public function test_i_should_see_the_password_reset_page_only_if_i_am_not_logged_in ()
    {
        $this->get('/password/reset/someToken')
             ->assertSee('Reset Password');

        $this->actingAs(factory(User::class)->create())
             ->get('/password/reset/someToken')
             ->assertRedirect('/home');
    }

    public function test_success_message_should_be_flashed_after_password_reset()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/password/email', ['email' => $user->email]);
        $response->assertSessionHas('status', 'We have e-mailed your password reset link!');
    }

    public function test_email_should_be_sent_on_password_reset()
    {
        $user = factory(User::class)->create();
        $this->post('/password/email', ['email' => $user->email]);

        $this->assertEmailWasSent();
        $this->assertEmailTo($user->email);
    }
}
