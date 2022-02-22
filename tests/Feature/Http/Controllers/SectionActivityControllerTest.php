<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Section;
use App\Models\SectionActivity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SectionActivityController
 */
class SectionActivityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected(): void
    {
        $sectionActivities = SectionActivity::factory()->count(3)->create();

        $response = $this->get(route('section-activity.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SectionActivityController::class,
            'store',
            \App\Http\Requests\SectionActivityStoreRequest::class
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
        $section = Section::factory()->create();

        $response = $this->post(route('section-activity.store'), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'section_id' => $section->id,
        ]);

        $sectionActivities = SectionActivity::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('date', $date)
            ->where('time', $time)
            ->where('section_id', $section->id)
            ->get();
        $this->assertCount(1, $sectionActivities);
        $sectionActivity = $sectionActivities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $sectionActivity = SectionActivity::factory()->create();

        $response = $this->get(route('section-activity.show', $sectionActivity));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SectionActivityController::class,
            'update',
            \App\Http\Requests\SectionActivityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected(): void
    {
        $sectionActivity = SectionActivity::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text;
        $date = $this->faker->date();
        $time = $this->faker->time();
        $section = Section::factory()->create();

        $response = $this->put(route('section-activity.update', $sectionActivity), [
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'section_id' => $section->id,
        ]);

        $sectionActivity->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $sectionActivity->title);
        $this->assertEquals($description, $sectionActivity->description);
        $this->assertEquals(Carbon::parse($date), $sectionActivity->date);
        $this->assertEquals($time, $sectionActivity->time);
        $this->assertEquals($section->id, $sectionActivity->section_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with(): void
    {
        $sectionActivity = SectionActivity::factory()->create();

        $response = $this->delete(route('section-activity.destroy', $sectionActivity));

        $response->assertNoContent();

        $this->assertDeleted($sectionActivity);
    }
}
