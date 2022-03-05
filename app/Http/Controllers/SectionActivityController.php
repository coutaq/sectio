<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionActivityStoreRequest;
use App\Http\Requests\SectionActivityUpdateRequest;
use App\Http\Resources\SectionActivityCollection;
use App\Http\Resources\SectionActivityResource;
use App\Models\SectionActivity;
use App\Notifications\ActionTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;    
use Illuminate\Support\Facades\Notification;

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
        
        $section_id = $request->section_id;
        
        return Inertia::render('SectionActivity/Create', compact('section_id'));   
    }
    /**
     * @param \App\Http\Requests\SectionActivityStoreRequest $request
     * @return \App\Http\Resources\SectionActivityResource
     */
    public function store(SectionActivityStoreRequest $request)
    {
        $validated = $request->validated();
        $format1 = 'Y-m-d';
        $format2 = 'H:i:s'; 
        $date = Carbon::parse($request['date'])->format($format1);
        $time = Carbon::parse($request['date'])->format($format2);
        $validated['date'] = $date;
        $validated['time'] = $time;
        $sectionActivity = SectionActivity::create($validated);
        $users = $sectionActivity->section->users;
        Notification::send($users, new ActionTime($sectionActivity,Carbon::parse($request['date'])));
        return Redirect::route('section.index');
    }
    public function edit(Request $request, SectionActivity $activity)
    {
        $activity    = new SectionActivityResource(SectionActivity::find($request->id));
        // dd($activity);
        return Inertia::render('SectionActivity/Edit', compact('activity'));   
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
        $validated = $request->validated();
        $format1 = 'Y-m-d';
        $format2 = 'H:i:s'; 
        $date = Carbon::parse($request['date'])->format($format1);
        $time = Carbon::parse($request['date'])->format($format2);
        $validated['date'] = $date;
        $validated['time'] = $time;
        $sectionActivity->update($validated);

     
        return Redirect::route('section.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SectionActivity $sectionActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SectionActivity $sectionActivity)
    {
        $sectionActivity->delete();

        return Redirect::route('section.index');
    }
}
