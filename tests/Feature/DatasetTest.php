<?php

namespace Tests\Feature;

use App\Dataset;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DatasetTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_i_should_see_datasets_when_i_visit_datasets_page ()
    {
        $datasets = factory(Dataset::class, 3)->create();

        $response = $this->get('/datasets');

        foreach ($datasets as $dataset) {
            $response->assertSee($dataset->name);
            $response->assertSee($dataset->overview);
        }
    }
}
