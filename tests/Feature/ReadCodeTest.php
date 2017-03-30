<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadCodeTest extends TestCase
{
    use DatabaseMigrations;
    protected $code;

    public function setUp ()
    {
        parent::setUp();
        $this->code = create('App\Code');
    }

    /** @test */
    public function an_user_can_view_codes ()
    {
        $this->get('/codes')
             ->assertSee($this->code->name);
    }

    /** @test */
    public function an_user_cannot_view_unpublished_codes ()
    {
        $code = create('App\Code', ['published' => false]);
        $this->get('/codes')
             ->assertDontSee($code->name);
    }

    /** @test */
    function a_creator_can_view_unpublished_codes ()
    {
        $user = create('App\User');
        $code = create('App\Code', ['published' => false, 'user_id' => $user->id]);

        $this->signIn($user)
            ->get('/codes')
            ->assertSee($code->name);
    }

    /** @test */
    function an_user_can_view_published_code ()
    {
        $this->get($this->code->path())
             ->assertSee($this->code->name);
    }

    /** @test */
    function an_user_cannot_view_unpublished_code ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $code = create('App\Code', ['published' => false]);
        $this->disableExceptionHandling()->get($code->path());
    }

    /** @test */
    function a_creator_can_view_unpublished_code ()
    {
        $user = create('App\User');
        $code = create('App\Code', ['published' => false, 'user_id' => $user->id]);

        $this->signIn($user)
             ->get($code->path())
             ->assertSee($code->name);
    }

    /** @test */
    function an_authenticated_user_can_view_their_own_codes ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $code = create('App\Code');
        $this->get('/codes?show=my')
             ->assertDontSee($code->name);

        $code = create('App\Code', ['user_id' => $user->id]);
        $this->get('/codes?show=my')
             ->assertSee($code->name);
    }
}
