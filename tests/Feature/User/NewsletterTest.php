<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Newsletter;

class NewsletterTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function newsletter_should_be_subscribed_on_registration ()
    {
        Newsletter::shouldReceive('subscribeOrUpdate');
        $username = 'test';
        $this->register(['username' => $username]);
    }

    /** @test */
    function users_may_subscribe_to_newsletter ()
    {
        Newsletter::shouldReceive('subscribeOrUpdate');
        $user = create('App\User');

        $this->signIn($user);

        $this->updateProfile($user, ['newsletter' => true])
             ->assertSessionMissing('errors');
    }

    /** @test */
    function users_may_unsubscribe_to_newsletter ()
    {
        Newsletter::shouldReceive('unsubscribe');
        $user = create('App\User');

        $this->signIn($user);

        $this->updateProfile($user, ['newsletter' => false])
             ->assertSessionMissing('errors');
    }

    protected function updateProfile($user, $overrides = [])
    {
        return $this->put(sprintf('/u/%s/edit', $user->username), $overrides + $user->toArray());
    }

    protected function register($overrides = [], $password = 'secret')
    {
        $user = make('App\User', $overrides);

        return $this->post('/register', ['password' => $password, 'password_confirmation' => 'secret'] + $user->toArray());
    }
}
