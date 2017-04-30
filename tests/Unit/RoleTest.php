<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $role;

    public function setUp ()
    {
        parent::setUp();
        $this->role = create('App\Role');
    }

    /** @test */
    public function a_role_has_many_users()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->role->users
        );
    }
}
