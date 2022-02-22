<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Round;
use App\Models\RoundActivity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RoundActivityController
 */
class RoundActivityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $roundActivities = RoundActivity::factory()->count(3)->create();

        $response = $this->get(route('round-activity.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoundActivityController::class,
            'store',
            \App\Http\Requests\RoundActivityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;
        $date = $this->faker->date();
        $time = $this->faker->time();
        $round = Round::factory()->create();

        $response = $this->post(route('round-activity.store'), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'round_id' => $round->id,
        ]);

        $roundActivities = RoundActivity::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('date', $date)
            ->where('time', $time)
            ->where('round_id', $round->id)
            ->get();
        $this->assertCount(1, $roundActivities);
        $roundActivity = $roundActivities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $roundActivity = RoundActivity::factory()->create();

        $response = $this->get(route('round-activity.show', $roundActivity));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoundActivityController::class,
            'update',
            \App\Http\Requests\RoundActivityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $roundActivity = RoundActivity::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;
        $date = $this->faker->date();
        $time = $this->faker->time();
        $round = Round::factory()->create();

        $response = $this->put(route('round-activity.update', $roundActivity), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'round_id' => $round->id,
        ]);

        $roundActivity->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $roundActivity->title);
        $this->assertEquals($description, $roundActivity->description);
        $this->assertEquals(Carbon::parse($date), $roundActivity->date);
        $this->assertEquals($time, $roundActivity->time);
        $this->assertEquals($round->id, $roundActivity->round_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $roundActivity = RoundActivity::factory()->create();

        $response = $this->delete(route('round-activity.destroy', $roundActivity));

        $response->assertNoContent();

        $this->assertDeleted($roundActivity);
    }
}
