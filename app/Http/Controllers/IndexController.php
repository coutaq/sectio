<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectionActivityResource;
use App\Http\Resources\SectionResource;
use App\Mail\ActionTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class IndexController extends Controller
{
    /**
     * Handle the incoming request. b 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        // $user = User::find($user->id);  
        // Mail::to($user)->send(new ActionTime());
        $sections = SectionResource::collection($user->sections()->with(['sectionActivities' => function($q){
            $q->whereDate('section_activities.date', Carbon::today());
        }])->get());

        return Inertia::render('Dashboard', compact('sections'));
    }
}
