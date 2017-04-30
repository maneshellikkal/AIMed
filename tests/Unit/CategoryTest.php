<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $category;

    public function setUp ()
    {
        parent::setUp();
        $this->category = create('App\Category');
    }

    /** @test */
    public function a_category_has_many_threads()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->category->threads
        );
    }
}
