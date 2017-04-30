<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $user;

    public function setUp ()
    {
        parent::setUp();
        $this->user = create('App\User');
    }

    /** @test */
    public function a_user_has_many_activations()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->activations
        );
    }

    /** @test */
    public function a_user_has_many_datasets ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->datasets
        );
    }

    /** @test */
    public function a_user_has_many_codes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->codes
        );
    }

    /** @test */
    public function a_user_has_many_threads ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->threads
        );
    }

    /** @test */
    public function a_user_has_many_replies ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->replies
        );
    }

    /** @test */
    public function a_user_has_many_votes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->votes
        );
    }

    /** @test */
    public function a_user_has_many_roles ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->roles
        );
    }
}
