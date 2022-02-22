<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;
use App\Http\Resources\SectionCollection;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SectionCollection
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $sections = SectionResource::collection($user->sections()->with('sectionActivities')->get());
        return Inertia::render('Section/Index', compact('sections'));
    }

    public function create(Request $request)
    {
        return Inertia::render('Section/Create');   
    }

    /**
     * @param \App\Http\Requests\SectionStoreRequest $request
     * @return \App\Http\Resources\SectionResource
     */
    public function store(SectionStoreRequest $request)
    {
        $section = Section::create($request->validated());
        Auth::user()->sections()->attach($section->id);
        return redirect()->route('section.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \App\Http\Resources\SectionResource
     */
    public function show(Request $request, Section $section)
    {
        return new SectionResource($section);
    }

    /**
     * @param \App\Http\Requests\SectionUpdateRequest $request
     * @param \App\Models\Section $section
     * @return \App\Http\Resources\SectionResource
     */
    public function update(SectionUpdateRequest $request, Section $section)
    {
        $section->update($request->validated());

        return new SectionResource($section);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Section $section)
    {
        $section->delete();

        return response()->noContent();
    }
}
