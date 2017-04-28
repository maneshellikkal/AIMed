<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateDatasetsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_may_not_create_datasets ()
    {
        $this->get('/datasets/publish')
            ->assertRedirect('/login');

        $this->post('/datasets')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_datasets ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $dataset = make('App\Dataset');
        $this->post('/datasets', $dataset->toArray());

        $this->assertDatabaseHas('datasets', [
            'name' => $dataset->name,
            'overview' => $dataset->overview,
            'user_id' => $user->id,
            'published' => false,
        ]);
    }

    /** @test */
    function a_dataset_requires_a_valid_name()
    {
        $this->publishDataset(['name' => null])
             ->assertSessionHasErrors('name');

        $this->publishDataset(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->publishDataset(['name' => str_random(51)])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_dataset_requires_a_valid_overview()
    {
        $this->publishDataset(['overview' => null])
             ->assertSessionHasErrors('overview');

        $this->publishDataset(['overview' => str_random(19)])
             ->assertSessionHasErrors('overview');

        $this->publishDataset(['overview' => str_random(81)])
             ->assertSessionHasErrors('overview');
    }

    /** @test */
    function a_dataset_requires_a_valid_description()
    {
        $this->publishDataset(['description' => null])
             ->assertSessionHasErrors('description');

        $this->publishDataset(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');
    }

    protected function publishDataset($overrides = [])
    {
        $this->signIn();
        $dataset = make('App\Dataset', $overrides);
        return $this->post('/datasets', $dataset->toArray());
    }
}
