<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateCodeTest extends TestCase
{
    use DatabaseMigrations;
    private $user;
    private $code;

    function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->code = create('App\Code', ['user_id' => $this->user->id ]);
    }

    /** @test */
    function guests_may_not_edit_codes ()
    {
        $this->get($this->code->path() . '/edit')
             ->assertRedirect('/login');

        $this->put($this->code->path())
             ->assertRedirect('/login');
    }

    /** @test */
    function any_authenticated_user_may_not_view_edit_code_page ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');

        $this->get($this->code->path() . '/edit')
             ->assertStatus(404);
    }

    /** @test */
    function any_authenticated_user_may_not_edit_code ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->put($this->code->path())
             ->assertStatus(403);
    }

    /** @test */
    function creator_may_edit_code ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        $this->get($this->code->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->code->path())
             ->assertStatus(302);
    }

    /** @test */
    function a_code_requires_a_valid_name ()
    {
        $this->updateCode(['name' => null])
             ->assertSessionHasErrors('name');

        $this->updateCode(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->updateCode(['name' => str_random(51)])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_code_requires_a_valid_description ()
    {
        $this->updateCode(['description' => null])
             ->assertSessionHasErrors('description');

        $this->updateCode(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');
    }

    /** @test */
    function a_code_requires_a_valid_code ()
    {
        $this->updateCode(['code' => null])
             ->assertSessionHasErrors('code');

        $this->updateCode(['code' => str_random(50001)])
             ->assertSessionHasErrors('code');
    }

    /** @test */
    function a_code_requires_a_valid_publish_bool ()
    {
        $this->updateCode(['publish' => 'string'])
             ->assertSessionHasErrors('publish');
    }

    protected function updateCode ($overrides = [])
    {
        $this->signIn($this->user);
        $this->code->fill(raw('App\Code', $overrides));

        return $this->put($this->code->path(), $this->code->toArray());
    }
}
