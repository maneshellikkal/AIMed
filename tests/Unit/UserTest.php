<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    protected $user;

    public function setUp ()
    {
        parent::setUp();
        $this->user = create('App\User');
    }

    /** @test */
    function a_user_can_make_a_string_path ()
    {
        $this->assertEquals(
            "/u/{$this->user->username}", $this->user->path()
        );
    }

    /** @test */
    function a_user_has_datasets ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->datasets
        );
    }
}
