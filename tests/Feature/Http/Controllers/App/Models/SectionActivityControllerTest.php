<?php

namespace Tests\Feature\Http\Controllers\App\Models;

use App\Models\Section;
use App\Models\SectionActivity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\App\Models\SectionActivityController
 */
class SectionActivityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $sectionActivities = SectionActivity::factory()->count(3)->create();

        $response = $this->get(route('section-activity.index'));

        $response->assertOk();
        $response->assertViewIs('sectionActivity.index');
        $response->assertViewHas('sectionActivities');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('section-activity.create'));

        $response->assertOk();
        $response->assertViewIs('sectionActivity.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\App\Models\SectionActivityController::class,
            'store',
            \App\Http\Requests\App\Models\SectionActivityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
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

        $response->assertRedirect(route('sectionActivity.index'));
        $response->assertSessionHas('sectionActivity.id', $sectionActivity->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $sectionActivity = SectionActivity::factory()->create();

        $response = $this->get(route('section-activity.show', $sectionActivity));

        $response->assertOk();
        $response->assertViewIs('sectionActivity.show');
        $response->assertViewHas('sectionActivity');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $sectionActivity = SectionActivity::factory()->create();

        $response = $this->get(route('section-activity.edit', $sectionActivity));

        $response->assertOk();
        $response->assertViewIs('sectionActivity.edit');
        $response->assertViewHas('sectionActivity');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\App\Models\SectionActivityController::class,
            'update',
            \App\Http\Requests\App\Models\SectionActivityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
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

        $response->assertRedirect(route('sectionActivity.index'));
        $response->assertSessionHas('sectionActivity.id', $sectionActivity->id);

        $this->assertEquals($title, $sectionActivity->title);
        $this->assertEquals($description, $sectionActivity->description);
        $this->assertEquals(Carbon::parse($date), $sectionActivity->date);
        $this->assertEquals($time, $sectionActivity->time);
        $this->assertEquals($section->id, $sectionActivity->section_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $sectionActivity = SectionActivity::factory()->create();

        $response = $this->delete(route('section-activity.destroy', $sectionActivity));

        $response->assertRedirect(route('sectionActivity.index'));

        $this->assertDeleted($sectionActivity);
    }
}
