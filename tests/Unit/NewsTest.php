<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $news;

    public function setUp ()
    {
        parent::setUp();
        $this->news = create('App\TwitterFeed');
    }

    /** @test */
    public function a_news_has_many_votes()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->news->votes
        );
    }
}
