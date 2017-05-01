<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivationTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $activation;

    public function setUp ()
    {
        parent::setUp();
        $this->activation = create('App\Activation');
    }

    /** @test */
    public function an_activation_belongs_to_a_user()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Model', $this->activation->user
        );
    }
}
