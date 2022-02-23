<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionActivityStoreRequest;
use App\Http\Requests\SectionActivityUpdateRequest;
use App\Http\Resources\SectionActivityCollection;
use App\Http\Resources\SectionActivityResource;
use App\Models\SectionActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionActivityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SectionActivityCollection
     */
    public function index(Request $request)
    {
        $sectionActivities = SectionActivity::all();

        return new SectionActivityCollection($sectionActivities);
    }
    public function create(Request $request)
    {
        return Inertia::render('SectionActivity/Create');   
    }
    /**
     * @param \App\Http\Requests\SectionActivityStoreRequest $request
     * @return \App\Http\Resources\SectionActivityResource
     */
    public function store(SectionActivityStoreRequest $request)
    {
        $sectionActivity = SectionActivity::create($request->validated());

        return new SectionActivityResource($sectionActivity);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \App\Http\Resources\SectionActivityResource
     */
    public function show(Request $request, SectionActivity $sectionActivity)
    {
        return new SectionActivityResource($sectionActivity);
    }

    /**
     * @param \App\Http\Requests\SectionActivityUpdateRequest $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \App\Http\Resources\SectionActivityResource
     */
    public function update(SectionActivityUpdateRequest $request, SectionActivity $sectionActivity)
    {
        $sectionActivity->update($request->validated());

        return new SectionActivityResource($sectionActivity);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SectionActivity $sectionActivity)
    {
        $sectionActivity->delete();

        return response()->noContent();
    }
}
