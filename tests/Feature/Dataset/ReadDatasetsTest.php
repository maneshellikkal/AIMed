<?php

namespace Tests\Feature\Dataset;

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
    public function an_user_can_view_all_datasets ()
    {
        $this->get('/datasets')
             ->assertSee($this->dataset->name);
    }

    /** @test */
    public function an_user_cannot_view_unpublished_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false]);
        $this->get('/datasets')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    function an_user_can_view_a_single_dataset ()
    {
        $this->get($this->dataset->path())
             ->assertSee($this->dataset->name);
    }

    /** @test */
    function an_user_cannot_view_unpublished_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $dataset = create('App\Dataset', ['published' => false]);
        $this->disableExceptionHandling()->get($dataset->path());
    }

    /** @test */
    function a_creator_can_view_unpublished_datasets ()
    {
        $user = create('App\User');
        $dataset = create('App\Dataset', ['published' => false, 'user_id' => $user->id]);

        $this->signIn($user)
             ->get('/datasets')
             ->assertSee($dataset->name);
    }

    /** @test */
    function an_user_can_view_featured_datasets ()
    {
        $dataset = create('App\Dataset', ['featured' => false]);
        $this->get('/datasets?featured=true')
             ->assertDontSee($dataset->name);

        $dataset = create('App\Dataset', ['featured' => true]);
        $this->get('/datasets?featured=true')
             ->assertSee($dataset->name);
    }

    /** @test */
    function an_authenticated_user_can_view_their_own_datasets ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $dataset = create('App\Dataset');
        $this->get('/datasets?author='.$user->username)
             ->assertDontSee($dataset->name);

        $dataset = create('App\Dataset', ['user_id' => $user->id]);
        $this->get('/datasets?author='.$user->username)
             ->assertSee($dataset->name);
    }
}
