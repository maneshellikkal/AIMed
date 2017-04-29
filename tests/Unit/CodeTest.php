<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CodeTest extends TestCase
{
    use DatabaseMigrations;
    protected $code;

    public function setUp ()
    {
        parent::setUp();
        $this->code = create('App\Code');
    }

    /** @test */
    public function a_code_can_make_a_string_path ()
    {
        $this->assertEquals(
            "/c/{$this->code->slug}", $this->code->path()
        );
    }

    /** @test */
    public function a_code_has_a_creator ()
    {
        $this->assertInstanceOf('App\User', $this->code->creator);
    }

    /** @test */
    public function a_code_belongs_to_a_dataset ()
    {
        $this->assertInstanceOf('App\Dataset', $this->code->dataset);
    }
}
