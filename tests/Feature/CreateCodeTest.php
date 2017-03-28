<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCodeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_may_not_create_codes ()
    {
        $dataset = create('App\Dataset');
        $this->get("/c/{$dataset->slug}/publish")
             ->assertRedirect('/login');

        $this->post('/codes')
             ->assertRedirect('/login');
    }

    /** @test */
    function an_user_may_not_create_code_for_unpublished_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false]);

        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');
        $this->disableExceptionHandling()
             ->signIn()
             ->get("/c/{$dataset->slug}/publish");
    }

    /** @test */
    function an_authenticated_user_can_create_codes ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $dataset = create('App\Dataset');
        $code = make('App\Code', ['dataset_id' => $dataset->id]);

        $this->post('/codes', $code->toArray());

        $this->assertDatabaseHas('codes', [
            'name' => $code->name,
            'description' => $code->description,
            'code' => $code->code,
            'user_id' => $user->id,
            'dataset_id' => $dataset->id,
            'published' => false,
        ]);
    }

    /** @test */
    function a_code_requires_a_valid_name()
    {
        $this->publishCode(['name' => null])
             ->assertSessionHasErrors('name');

        $this->publishCode(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->publishCode(['name' => str_random(51)])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_code_requires_a_valid_description()
    {
        $this->publishCode(['description' => null])
             ->assertSessionHasErrors('description');

        $this->publishCode(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');
    }

    /** @test */
    function a_code_requires_valid_code()
    {
        $this->publishCode(['code' => null])
             ->assertSessionHasErrors('code');

        $this->publishCode(['code' => str_random(50001)])
             ->assertSessionHasErrors('code');
    }

    /** @test */
    function a_code_requires_valid_dataset()
    {
        $this->publishCode(['dataset_id' => 0])
             ->assertSessionHasErrors('dataset_id');

        $dataset = create('App\Dataset');
        $this->publishCode(['dataset_id' => $dataset->id])
             ->assertSessionMissing('dataset_id');
    }

    protected function publishCode($overrides = [])
    {
        $this->signIn();
        $code = make('App\Code', $overrides);
        return $this->post('/codes', $code->toArray());
    }
}
