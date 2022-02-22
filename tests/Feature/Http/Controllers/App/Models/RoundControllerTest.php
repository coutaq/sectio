<?php

namespace Tests\Feature\Http\Controllers\App\Models;

use App\Models\Round;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\App\Models\RoundController
 */
class RoundControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $rounds = Round::factory()->count(3)->create();

        $response = $this->get(route('round.index'));

        $response->assertOk();
        $response->assertViewIs('round.index');
        $response->assertViewHas('rounds');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('round.create'));

        $response->assertOk();
        $response->assertViewIs('round.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\App\Models\RoundController::class,
            'store',
            \App\Http\Requests\App\Models\RoundStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
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

        $response->assertRedirect(route('round.index'));
        $response->assertSessionHas('round.id', $round->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $round = Round::factory()->create();

        $response = $this->get(route('round.show', $round));

        $response->assertOk();
        $response->assertViewIs('round.show');
        $response->assertViewHas('round');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $round = Round::factory()->create();

        $response = $this->get(route('round.edit', $round));

        $response->assertOk();
        $response->assertViewIs('round.edit');
        $response->assertViewHas('round');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\App\Models\RoundController::class,
            'update',
            \App\Http\Requests\App\Models\RoundUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $round = Round::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->put(route('round.update', $round), [
            'title' => $title,
            'description' => $description,
        ]);

        $round->refresh();

        $response->assertRedirect(route('round.index'));
        $response->assertSessionHas('round.id', $round->id);

        $this->assertEquals($title, $round->title);
        $this->assertEquals($description, $round->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $round = Round::factory()->create();

        $response = $this->delete(route('round.destroy', $round));

        $response->assertRedirect(route('round.index'));

        $this->assertDeleted($round);
    }
}
