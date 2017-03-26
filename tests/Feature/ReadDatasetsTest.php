<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadDatasetsTest extends TestCase
{
    use DatabaseMigrations;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->dataset = create('App\Dataset');
    }

    /** @test */
    public function a_user_can_view_all_datasets ()
    {
        $this->get('/datasets')
             ->assertSee($this->dataset->name);
    }

    /** @test */
    public function a_user_cannot_view_unpublished_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false]);
        $this->get('/datasets')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    function a_user_can_view_a_single_dataset ()
    {
        $this->get($this->dataset->path())
             ->assertSee($this->dataset->name);
    }

    /** @test */
    function a_user_cannot_view_unpublished_dataset ()
    {
        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $dataset = create('App\Dataset', ['published' => false]);
        $this->disableExceptionHandling()->get($dataset->path());
    }

    function a_user_can_view_featured_datasets ()
    {
        $this->get('/datasets');
    }
}
