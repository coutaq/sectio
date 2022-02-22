<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SectionController
 */
class SectionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $sections = Section::factory()->count(3)->create();

        $response = $this->get(route('section.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SectionController::class,
            'store',
            \App\Http\Requests\SectionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->post(route('section.store'), [
            'title' => $title,
            'description' => $description,
        ]);

        $sections = Section::query()
            ->where('title', $title)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $sections);
        $section = $sections->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $section = Section::factory()->create();

        $response = $this->get(route('section.show', $section));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SectionController::class,
            'update',
            \App\Http\Requests\SectionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $section = Section::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->put(route('section.update', $section), [
            'title' => $title,
            'description' => $description,
        ]);

        $section->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $section->title);
        $this->assertEquals($description, $section->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $section = Section::factory()->create();

        $response = $this->delete(route('section.destroy', $section));

        $response->assertNoContent();

        $this->assertDeleted($section);
    }
}
