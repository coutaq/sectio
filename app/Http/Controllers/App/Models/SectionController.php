<?php

namespace App\Http\Controllers\App\Models;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Models\SectionStoreRequest;
use App\Http\Requests\App\Models\SectionUpdateRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sections = Section::all();

        return view('section.index', compact('sections'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('section.create');
    }

    /**
     * @param \App\Http\Requests\App\Models\SectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionStoreRequest $request)
    {
        $section = Section::create($request->validated());

        $request->session()->flash('section.id', $section->id);

        return redirect()->route('section.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Section $section)
    {
        return view('section.show', compact('section'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Section $section)
    {
        return view('section.edit', compact('section'));
    }

    /**
     * @param \App\Http\Requests\App\Models\SectionUpdateRequest $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request, Section $section)
    {
        $section->update($request->validated());

        $request->session()->flash('section.id', $section->id);

        return redirect()->route('section.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Section $section)
    {
        $section->delete();

        return redirect()->route('section.index');
    }
}
