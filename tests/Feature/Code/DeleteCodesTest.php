<?php

namespace Tests\Feature\Code;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteCodesTest extends TestCase
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
    public function guests_may_not_delete_any_code ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->delete($this->code->path());
    }

    /** @test */
    public function any_user_may_not_delete_any_code ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->delete($this->code->path());
    }

    /** @test */
    public function admin_may_delete_any_code ()
    {
        $this->signIn($this->createAdmin());

        $this->delete($this->code->path());
        $this->assertDatabaseMissing('codes', ['id' => $this->code->id]);
    }
}
