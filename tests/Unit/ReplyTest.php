<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $reply;

    public function setUp ()
    {
        parent::setUp();
        $this->reply = create('App\Reply');
    }

    /** @test */
    public function a_reply_belongs_to_a_user()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Model', $this->reply->creator
        );
    }

    /** @test */
    public function a_reply_belongs_belongs_to_a_thread()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Model', $this->reply->thread
        );
    }
}
