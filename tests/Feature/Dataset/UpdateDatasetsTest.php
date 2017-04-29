<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateDatasetsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->dataset = create('App\Dataset', ['user_id' => $this->user->id, 'published' => false]);
    }

    /** @test */
    public function guests_may_not_edit_datasets ()
    {
        $this->get($this->dataset->path() . '/edit')
             ->assertRedirect('/login');

        $this->put($this->dataset->path())
             ->assertRedirect('/login');

        $this->post($this->dataset->path() . '/file')
             ->assertRedirect('/login');
    }

    /** @test */
    public function any_authenticated_user_may_not_see_edit_dataset_page ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->get($this->dataset->path() . '/edit');
    }

    /** @test */
    public function any_authenticated_user_may_not_edit_dataset ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->put($this->dataset->path());
    }

    /** @test */
    public function any_authenticated_user_may_not_upload_file ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->post($this->dataset->path() . '/file', ['file' => UploadedFile::fake()->create('file.pdf')]);
    }

    /** @test */
    public function creator_may_edit_dataset ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        $this->get($this->dataset->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->dataset->path());
    }

    /** @test */
    public function admin_may_edit_dataset ()
    {
        $this->disableExceptionHandling()->signIn($this->createAdmin());

        $this->get($this->dataset->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->dataset->path());
    }

    /** @test */
    public function creator_may_upload_files ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        for ($i = 1; $i <= 20; $i++) {
            $this->post($this->dataset->path() . '/file', ['file' => UploadedFile::fake()->create('file.pdf')])
                 ->assertStatus(200);
        }

        $this->post($this->dataset->path() . '/file', ['file' => UploadedFile::fake()->create('file.pdf')])
             ->assertStatus(403);
    }

    /** @test */
    public function admin_may_upload_files ()
    {
        $this->disableExceptionHandling()->signIn($this->createAdmin());

        for ($i = 1; $i <= 20; $i++) {
            $this->post($this->dataset->path() . '/file', ['file' => UploadedFile::fake()->create('file.pdf')])
                 ->assertStatus(200);
        }

        $this->post($this->dataset->path() . '/file', ['file' => UploadedFile::fake()->create('file.pdf')])
             ->assertStatus(403);
    }

    /** @test */
    public function a_dataset_requires_a_valid_name ()
    {
        $this->updateDataset(['name' => null])
             ->assertSessionHasErrors('name');

        $this->updateDataset(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->updateDataset(['name' => str_random(51)])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_dataset_requires_a_valid_overview ()
    {
        $this->updateDataset(['overview' => null])
             ->assertSessionHasErrors('overview');

        $this->updateDataset(['overview' => str_random(19)])
             ->assertSessionHasErrors('overview');

        $this->updateDataset(['overview' => str_random(81)])
             ->assertSessionHasErrors('overview');
    }

    /** @test */
    public function a_dataset_requires_a_valid_description ()
    {
        $this->updateDataset(['description' => null])
             ->assertSessionHasErrors('description');

        $this->updateDataset(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_dataset_requires_a_valid_image ()
    {
        $this->updateDataset(['image' => UploadedFile::fake()->create('file.pdf')])
             ->assertSessionHasErrors('image');

        $this->updateDataset(['image' => UploadedFile::fake()->image('file.png')->size(6000)])
             ->assertSessionHasErrors('image');
    }

    /** @test */
    public function a_dataset_must_be_published_when_image_and_files_are_added ()
    {
        $this->signIn($this->user);
        $this->assertEquals(false, $this->dataset->published);

        $this->post($this->dataset->path() . '/file', ['file' => UploadedFile::fake()->create('file.pdf')]);

        $this->updateDataset(['image' => UploadedFile::fake()->image('file.png')]);

        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'published' => true]);
    }

    /** @test */
    public function guests_may_not_publish_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->get($this->dataset->path() . '/publish');
    }

    /** @test */
    public function any_user_may_not_publish_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->get($this->dataset->path() . '/publish');
    }

    /** @test */
    public function admin_may_publish_any_dataset ()
    {
        $this->signIn($this->createAdmin());

        $this->get($this->dataset->path() . '/publish');
        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'published' => true]);

        $this->get($this->dataset->path() . '/publish');
        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'published' => false]);
    }

    /** @test */
    public function guests_may_not_feature_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->get($this->dataset->path() . '/feature');
    }

    /** @test */
    public function any_user_may_not_feature_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->get($this->dataset->path() . '/feature');
    }

    /** @test */
    public function admin_may_feature_any_dataset ()
    {
        $this->signIn($this->createAdmin());

        $this->get($this->dataset->path() . '/feature');
        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'featured' => true]);

        $this->get($this->dataset->path() . '/feature');
        $this->assertDatabaseHas('datasets', ['id' => $this->dataset->id, 'featured' => false]);
    }

    protected function updateDataset ($overrides = [])
    {
        $this->signIn($this->user);
        $this->dataset->fill(raw('App\Dataset', $overrides));

        return $this->put($this->dataset->path(), $this->dataset->toArray());
    }
}
