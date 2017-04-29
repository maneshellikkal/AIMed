<?php

namespace Tests\Feature\Discussion;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    private $user;
    private $discussion;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->discussion = create('App\Thread', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function guests_may_not_delete_any_discussion ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->delete($this->discussion->path());
    }

    /** @test */
    public function any_user_may_not_delete_any_discussion ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn()
             ->delete($this->discussion->path());
    }

    /** @test */
    public function creator_may_delete_discussion ()
    {
        $this->signIn($this->user);
        $this->delete($this->discussion->path());
        $this->assertDatabaseMissing('threads', ['id' => $this->discussion->id]);
    }

    /** @test */
    public function admin_may_delete_any_discussion ()
    {
        $this->signIn($this->createAdmin());

        $this->delete($this->discussion->path());
        $this->assertDatabaseMissing('threads', ['id' => $this->discussion->id]);
    }
}
