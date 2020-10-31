<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Timing;

class NewTimingTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * test create new timing.
     *
     * @return void
     */
    public function testNewTiming()
    {    
        $response = $this->post(route('timing.store'), [
            'timeFrame' => $this->faker->lexify('???'),
        ]);

        $timing = Timing::first();

        $this->assertDatabaseCount($timing->getTable(), 1);
        $response->assertRedirect($timing->path());
    }
}
