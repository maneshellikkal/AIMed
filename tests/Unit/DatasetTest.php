<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DatasetTest extends TestCase
{
    use DatabaseMigrations;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->dataset = create('App\Dataset');
    }

    /** @test */
    function a_dataset_can_make_a_string_path ()
    {
        $dataset = create('App\Dataset');
        $this->assertEquals(
            "/d/{$dataset->slug}", $dataset->path()
        );
    }

    /** @test */
    function a_dataset_has_a_creator ()
    {
        $this->assertInstanceOf('App\User', $this->dataset->creator);
    }
}
