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
use Illuminate\Support\Facades\Redirect;
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

    public function edit(Request $request, Section $section)
    {
        $section = new SectionResource($section->with('admins', 'pupils')->first());
        $availible_admins = UserResource::collection(
            User::select('users.*')->leftJoin('section_user', 'users.id', '=', 'section_user.user_id')
            ->join('roles', 'users.role_id', 'roles.id')
            ->where('slug', 'admin')
            ->where(function($query) use ($section){
                $query->where('section_id', '!=', $section->id)
                ->orWhereNull('section_id');
            })->get());  

  
            $availible_pupils = UserResource::collection(
                User::select('users.*')->leftJoin('section_user', 'users.id', '=', 'section_user.user_id')
                ->join('roles', 'users.role_id', 'roles.id')
                ->where('slug', 'pupil')
                ->where(function($query) use ($section){
                    $query->where('section_id', '!=', $section->id)
                    ->orWhereNull('section_id');
                })->get());
        return Inertia::render('Section/Edit', compact('section', 'availible_admins', 'availible_pupils')); 
    }
    /**     
     * @param \App\Http\Requests\SectionUpdateRequest $request
     * @param \App\Models\Section $section
     * @return \App\Http\Resources\SectionResource
     */
    public function update(SectionUpdateRequest $request, Section $section)
    {
        $section->update($request->validated());

        return redirect()->route('section.index');
    }   
    public function removeAdmin(Request $request){
        $section = Section::findOrFail($request->section_id);
        if(count($section->admins) >1){
            $section->admins()->detach($request->user_id);  
        }
        // return redirect()->back();
        return Redirect::route('section.edit', $section);
    }
    public function addAdmins(Request $request){
        $section = Section::findOrFail($request->section_id);
        foreach ($request->admins as $admin){
            $section->admins()->attach($admin['id']);  
        }
        return Redirect::route('section.edit', $section);
    }

    public function removePupil(Request $request){
        $section = Section::findOrFail($request->section_id);
        $section->pupils()->detach($request->user_id);  
        return Redirect::route('section.edit', $section);
    }
    public function addPupils(Request $request){
        $section = Section::findOrFail($request->section_id);
      
        foreach ($request->pupils as $pupil){
            $section->pupils()->attach($pupil['id']);  
        }
        return Redirect::route('section.edit', $section);
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
