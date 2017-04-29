<?php

namespace Tests\Feature\Dataset;

use Carbon\Carbon;
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
    public function view_all_datasets ()
    {
        $this->get('/datasets')
             ->assertSee($this->dataset->name);
    }

    /** @test */
    public function view_featured_datasets ()
    {
        $this->get('/datasets?featured=true')
             ->assertDontSee($this->dataset->name);

        $dataset = create('App\Dataset', ['featured' => true]);
        $this->get('/datasets?featured=true')
             ->assertSee($dataset->name);
    }

    /** @test */
    public function view_trending_datasets ()
    {
        $this->signIn();

        $dataset = create('App\Dataset', ['created_at' => Carbon::now()->subDays(10)]);
        $dataset->vote();

        $this->get('/datasets?trending=1')
             ->assertDontSee($dataset->name);

        $dataset = create('App\Dataset');
        $dataset->vote();

        $this->get('/datasets?trending=1')
             ->assertSee($dataset->name);
    }

    /** @test */
    public function view_popular_datasets ()
    {
        $this->signIn();

        $datasets = create('App\Dataset', [], 30)->random(3);
        foreach($datasets as $dataset) {
            $dataset->vote();
        }

        foreach($datasets as $dataset) {
            $this->get('/datasets?popular=1')
                 ->assertSee($dataset->name);
        }
    }

    /** @test */
    public function authenticated_user_may_view_own_datasets ()
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

    /** @test */
    public function cannot_view_unpublished_dataset_in_all ()
    {
        $dataset = create('App\Dataset', ['published' => false]);
        $this->get('/datasets')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function cannot_view_unpublished_dataset_in_featured ()
    {
        $dataset = create('App\Dataset', ['published' => false, 'featured' => true]);
        $this->get('/datasets?featured=true')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function cannot_view_unpublished_dataset_in_trending ()
    {
        $this->signIn();

        $dataset = create('App\Dataset', ['published' => false]);
        $dataset->vote();

        $this->get('/datasets?trending=1')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function cannot_view_unpublished_dataset_in_popular ()
    {
        $this->signIn();

        $dataset = create('App\Dataset', ['published' => false]);
        $dataset->vote();

        $this->get('/datasets?popular=1')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function view_a_single_dataset ()
    {
        $this->get($this->dataset->path())
             ->assertSee($this->dataset->name);
    }

    /** @test */
    public function dataset_should_list_its_codes ()
    {
        $codes = create('App\Code', ['dataset_id' => $this->dataset->id], 5);
        foreach($codes as $code){
            $this->get($this->dataset->path())
                 ->assertSee($code->name);
        }
    }

    /** @test */
    public function may_not_view_unpublished_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $dataset = create('App\Dataset', ['published' => false]);
        $this->disableExceptionHandling()->get($dataset->path());
    }

    /** @test */
    public function owner_can_view_unpublished_datasets ()
    {
        $user = create('App\User');
        $dataset = create('App\Dataset', ['published' => false, 'user_id' => $user->id]);

        $this->signIn($user);
        $this->get('/datasets')
             ->assertSee($dataset->name);

        $this->get($dataset->path())
             ->assertSee($dataset->name);
    }

    /** @test */
    public function admin_can_view_unpublished_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false]);

        $this->signIn($this->createAdmin());

        $this->get($dataset->path())
             ->assertSee($dataset->name);
    }

    /** @test */
    public function anyone_can_search_for_datasets()
    {
        $dataset = create('App\Dataset');
        create('App\Dataset', [], 30);

        $this->get('/datasets?search='.substr($dataset->name, 0, 5))
            ->assertSee($dataset->name);
    }
}
