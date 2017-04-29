<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PublishDatasetsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    private $user;
    private $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->dataset = create('App\Dataset', ['user_id' => $this->user->id, 'published' => false]);
    }

    /** @test */
    public function guests_may_not_publish_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->get($this->dataset->path() . '/publish');
    }

    /** @test */
    public function any_user_may_not_publish_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->get($this->dataset->path() . '/publish');
    }

    /** @test */
    public function admin_may_publish_any_dataset ()
    {
        $this->signIn($this->createAdmin());

        $this->get($this->dataset->path() . '/publish');
        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'published' => true]);

        $this->get($this->dataset->path() . '/publish');
        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'published' => false]);
    }
}
