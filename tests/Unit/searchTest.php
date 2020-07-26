<?php

namespace Tests\Unit;

use Tests\TestCase;

class searchTest extends TestCase
{
    /**
     * Check that the main page loads.
     *
     * @return void
     */
    public function testRootLoads()
    {
        $this->get('/')->assertStatus(200);
    }

    /**
     * Check that a 404 is returned for nonsense URLs.
     *
     * @return void
     */
    public function test404()
    {
        $this->get('/does-not-exist')->assertStatus(404);
    }

    /**
     * Check that the API connects and returns the necessary data.
     *
     * @return void
     */
    public function testSearchApi()
    {
        $this
            ->get('/api/search/?keyword=example')
            ->assertStatus(200)
            ->assertJsonStructure([
                'results',
                'search' => [
                    'items',
                    'pageInfo'
                ],
            ]);
    }
}
