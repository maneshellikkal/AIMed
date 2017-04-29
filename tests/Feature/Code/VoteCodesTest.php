<?php

namespace Tests\Feature\Code;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoteCodesTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    private $user;
    private $code;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->code = create('App\Code', ['user_id' => $this->user->id, 'published' => false]);
    }

    /** @test */
    public function guests_may_not_vote_code ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->post($this->code->path() . '/vote');
    }

    /** @test */
    public function any_user_may_vote_or_abstain_code ()
    {
        $this->signIn($this->user);

        $this->post($this->code->path() . '/vote');

        $this->assertEquals(1, $this->code->votes()->count());

        $this->post($this->code->path() . '/vote');

        $this->assertEquals(0, $this->code->votes()->count());
    }
}
