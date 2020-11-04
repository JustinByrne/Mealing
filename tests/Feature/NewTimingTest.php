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
        $response = $this->post(route('timings.store'), [
            'timeFrame' => $this->faker->lexify('???'),
        ]);

        $timing = Timing::first();

        $this->assertDatabaseCount($timing->getTable(), 1);
        $response->assertRedirect($timing->path());
    }

    /**
     * test create new timing without timeFrame.
     * 
     * @return void
     */
    public function testNewTimingWithTimeFrameNull()
    {
        $response = $this->post(route('timings.store'), [
            'timeFrame' => null,
        ]);

        $response->assertSessionHasErrors(['timeFrame']);
    }

    /**
     * test update timing.
     * 
     * @return void
     */
    public function testUpdateTiming()
    {
        $timing = Timing::factory()->create();

        // new data
        $timeFrame = $this->faker->lexify('???');

        $response = $this->patch(route('timings.update', [$timing->id]), [
            'timeFrame' => $timeFrame,
        ]);

        $this->assertEquals($timeFrame, Timing::first()->timeFrame);
        $response->assertRedirect($timing->path());
    }

    /**
     * test timing can be deleted.
     * 
     * @return void
     */
    public function testDeleteTiming()
    {
        $this->withoutExceptionHandling();
        
        $timing = Timing::factory()->create();

        $this->assertDatabaseCount($timing->getTable(), 1);

        $this->delete(route('timings.destroy', [$timing->id]));

        $this->assertSoftDeleted($timing);
    }
}
