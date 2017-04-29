<?php

namespace Tests\Feature\Discussion;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $discussion;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->discussion = create('App\Thread', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function guests_may_not_participate_in_discussions ()
    {
        $this->get($this->discussion->path())
             ->assertDontSee('Leave a Reply');

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->disableExceptionHandling()
             ->post($this->discussion->path().'/replies');
    }

    /** @test */
    public function authenticated_user_may_leave_reply ()
    {
        $this->signIn();
        $this->get($this->discussion->path())
             ->assertSee('Leave a Reply');

        $this->disableExceptionHandling()
             ->leaveReply();
    }

    /** @test */
    public function a_reply_requires_a_valid_body()
    {
        $this->leaveReply(['body' => null])
             ->assertSessionHasErrors('body');

        $this->leaveReply(['body' => str_random(5001)])
             ->assertSessionHasErrors('body');

        $this->leaveReply(['body' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    protected function leaveReply($overrides = [])
    {
        $this->signIn();
        $discussion = make('App\Reply', $overrides);
        return $this->post($this->discussion->path().'/replies', $discussion->toArray());
    }
}
