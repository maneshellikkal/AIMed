<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $thread;

    public function setUp ()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_thread_belongs_to_a_user()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Model', $this->thread->creator
        );
    }

    /** @test */
    public function a_thread_belongs_to_a_category()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Model', $this->thread->category
        );
    }

    /** @test */
    public function a_thread_has_many_replies()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->thread->replies
        );
    }
}
