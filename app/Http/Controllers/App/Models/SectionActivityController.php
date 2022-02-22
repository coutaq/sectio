<?php

namespace App\Http\Controllers\App\Models;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Models\SectionActivityStoreRequest;
use App\Http\Requests\App\Models\SectionActivityUpdateRequest;
use App\Models\SectionActivity;
use Illuminate\Http\Request;

class SectionActivityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sectionActivities = SectionActivity::all();

        return view('sectionActivity.index', compact('sectionActivities'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('sectionActivity.create');
    }

    /**
     * @param \App\Http\Requests\App\Models\SectionActivityStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionActivityStoreRequest $request)
    {
        $sectionActivity = SectionActivity::create($request->validated());

        $request->session()->flash('sectionActivity.id', $sectionActivity->id);

        return redirect()->route('sectionActivity.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SectionActivity $sectionActivity)
    {
        return view('sectionActivity.show', compact('sectionActivity'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SectionActivity $sectionActivity)
    {
        return view('sectionActivity.edit', compact('sectionActivity'));
    }

    /**
     * @param \App\Http\Requests\App\Models\SectionActivityUpdateRequest $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \Illuminate\Http\Response
     */
    public function update(SectionActivityUpdateRequest $request, SectionActivity $sectionActivity)
    {
        $sectionActivity->update($request->validated());

        $request->session()->flash('sectionActivity.id', $sectionActivity->id);

        return redirect()->route('sectionActivity.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SectionActivity $sectionActivity)
    {
        $sectionActivity->delete();

        return redirect()->route('sectionActivity.index');
    }
}
