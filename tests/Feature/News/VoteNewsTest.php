<?php

namespace Tests\Feature\News;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoteNewsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $news;

    public function setUp ()
    {
        parent::setUp();
        $this->news = create('App\TwitterFeed');
    }

    /** @test */
    public function guests_may_not_vote_news ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->post($this->news->path() . '/vote');
    }

    /** @test */
    public function any_user_may_vote_or_abstain_news ()
    {
        $this->signIn();

        $this->post($this->news->path() . '/vote');

        $this->assertEquals(1, $this->news->votes()->count());

        $this->post($this->news->path() . '/vote');

        $this->assertEquals(0, $this->news->votes()->count());
    }
}
