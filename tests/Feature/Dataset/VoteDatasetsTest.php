<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoteDatasetsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->dataset = create('App\Dataset', ['user_id' => $this->user->id, 'published' => false]);
    }

    /** @test */
    public function guests_may_not_vote_dataset ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->post($this->dataset->path() . '/vote');
    }

    /** @test */
    public function any_user_may_vote_or_abstain_dataset ()
    {
        $this->signIn($this->user);

        $this->post($this->dataset->path() . '/vote');

        $this->assertEquals(1, $this->dataset->votes()->count());

        $this->post($this->dataset->path() . '/vote');

        $this->assertEquals(0, $this->dataset->votes()->count());
    }
}
