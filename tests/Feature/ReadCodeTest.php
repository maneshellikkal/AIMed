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
    public function a_user_can_view_all_codes ()
    {
        $this->get('/codes')
             ->assertSee($this->code->name);
    }

    /** @test */
    public function a_user_cannot_view_unpublished_codes ()
    {
        $code = create('App\Code', ['published' => false]);
        $this->get('/codes')
             ->assertDontSee($code->name);
    }

    /** @test */
    function a_user_can_view_a_single_code ()
    {
        $this->get($this->code->path())
             ->assertSee($this->code->name);
    }

    /** @test */
    function a_user_cannot_view_unpublished_code ()
    {
        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $code = create('App\Code', ['published' => false]);
        $this->disableExceptionHandling()->get($code->path());
    }
}
