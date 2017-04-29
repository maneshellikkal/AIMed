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
    public function a_dataset_can_make_a_string_path ()
    {
        $this->assertEquals(
            "/d/{$this->dataset->slug}", $this->dataset->path()
        );
    }

    /** @test */
    public function a_dataset_has_a_creator ()
    {
        $this->assertInstanceOf('App\User', $this->dataset->creator);
    }

    /** @test */
    public function a_dataset_has_codes ()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->dataset->codes);
    }
}
