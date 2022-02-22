<?php

namespace Tests\Feature\Http\Controllers\App\Models;

use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\App\Models\SectionController
 */
class SectionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $sections = Section::factory()->count(3)->create();

        $response = $this->get(route('section.index'));

        $response->assertOk();
        $response->assertViewIs('section.index');
        $response->assertViewHas('sections');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('section.create'));

        $response->assertOk();
        $response->assertViewIs('section.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\App\Models\SectionController::class,
            'store',
            \App\Http\Requests\App\Models\SectionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
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

        $response->assertRedirect(route('section.index'));
        $response->assertSessionHas('section.id', $section->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $section = Section::factory()->create();

        $response = $this->get(route('section.show', $section));

        $response->assertOk();
        $response->assertViewIs('section.show');
        $response->assertViewHas('section');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $section = Section::factory()->create();

        $response = $this->get(route('section.edit', $section));

        $response->assertOk();
        $response->assertViewIs('section.edit');
        $response->assertViewHas('section');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\App\Models\SectionController::class,
            'update',
            \App\Http\Requests\App\Models\SectionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $section = Section::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;

        $response = $this->put(route('section.update', $section), [
            'title' => $title,
            'description' => $description,
        ]);

        $section->refresh();

        $response->assertRedirect(route('section.index'));
        $response->assertSessionHas('section.id', $section->id);

        $this->assertEquals($title, $section->title);
        $this->assertEquals($description, $section->description);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $section = Section::factory()->create();

        $response = $this->delete(route('section.destroy', $section));

        $response->assertRedirect(route('section.index'));

        $this->assertDeleted($section);
    }
}
