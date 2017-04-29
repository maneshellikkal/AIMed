<?php

namespace Tests\Feature\Discussion;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    private $user;
    private $discussion;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->discussion = create('App\Thread', ['user_id' => $this->user->id ]);
    }

    /** @test */
    public function guests_may_not_edit_discussions ()
    {
        $this->get($this->discussion->path() . '/edit')
             ->assertRedirect('/login');

        $this->put($this->discussion->path())
             ->assertRedirect('/login');
    }

    /** @test */
    public function any_authenticated_user_may_not_view_edit_discussion_page ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->get($this->discussion->path() . '/edit');
    }

    /** @test */
    public function any_authenticated_user_may_not_edit_discussion ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->put($this->discussion->path());
    }

    /** @test */
    public function creator_may_edit_discussion ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        $this->get($this->discussion->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->discussion->path());
    }

    /** @test */
    public function admin_may_edit_discussion ()
    {
        $this->disableExceptionHandling()->signIn($this->createAdmin());

        $this->get($this->discussion->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->discussion->path());
    }

    /** @test */
    public function a_discussion_requires_a_valid_name()
    {
        $this->updateDiscussion(['name' => null])
             ->assertSessionHasErrors('name');

        $this->updateDiscussion(['name' => str_random(300)])
             ->assertSessionHasErrors('name');

        $this->updateDiscussion(['name' => str_random(51)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_discussion_requires_a_valid_body()
    {
        $this->updateDiscussion(['body' => null])
             ->assertSessionHasErrors('body');

        $this->updateDiscussion(['body' => str_random(10001)])
             ->assertSessionHasErrors('body');

        $this->updateDiscussion(['body' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_discussion_requires_valid_category ()
    {
        $this->signIn($this->user)
             ->put($this->discussion->path(), ['category_id' => 0] + $this->discussion->toArray())
             ->assertSessionHasErrors('category_id');

        $category = create('App\Category');
        $this->updateDiscussion(['category_id' => $category->id])
             ->assertSessionMissing('errors');
    }

    protected function updateDiscussion ($overrides = [])
    {
        $this->signIn($this->user);
        $this->discussion->fill(raw('App\Thread', $overrides));

        return $this->put($this->discussion->path(), $this->discussion->toArray());
    }
}
