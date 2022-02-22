<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Round;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RoundController
 */
class RoundControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $rounds = Round::factory()->count(3)->create();

        $response = $this->get(route('round.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoundController::class,
            'store',
            \App\Http\Requests\RoundStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->post(route('round.store'), [
            'title' => $title,
            'description' => $description,
        ]);

        $rounds = Round::query()
            ->where('title', $title)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $rounds);
        $round = $rounds->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $round = Round::factory()->create();

        $response = $this->get(route('round.show', $round));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RoundController::class,
            'update',
            \App\Http\Requests\RoundUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $round = Round::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->put(route('round.update', $round), [
            'title' => $title,
            'description' => $description,
        ]);

        $round->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $round->title);
        $this->assertEquals($description, $round->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $round = Round::factory()->create();

        $response = $this->delete(route('round.destroy', $round));

        $response->assertNoContent();

        $this->assertDeleted($round);
    }
}
