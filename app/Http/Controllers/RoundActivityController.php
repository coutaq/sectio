<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoundActivityStoreRequest;
use App\Http\Requests\RoundActivityUpdateRequest;
use App\Http\Resources\RoundActivityCollection;
use App\Http\Resources\RoundActivityResource;
use App\Models\RoundActivity;
use Illuminate\Http\Request;

class RoundActivityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\RoundActivityCollection
     */
    public function index(Request $request)
    {
        $roundActivities = RoundActivity::all();

        return new RoundActivityCollection($roundActivities);
    }

    /**
     * @param \App\Http\Requests\RoundActivityStoreRequest $request
     * @return \App\Http\Resources\RoundActivityResource
     */
    public function store(RoundActivityStoreRequest $request)
    {
        $roundActivity = RoundActivity::create($request->validated());

        return new RoundActivityResource($roundActivity);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \App\Http\Resources\RoundActivityResource
     */
    public function show(Request $request, RoundActivity $roundActivity)
    {
        return new RoundActivityResource($roundActivity);
    }

    /**
     * @param \App\Http\Requests\RoundActivityUpdateRequest $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \App\Http\Resources\RoundActivityResource
     */
    public function update(RoundActivityUpdateRequest $request, RoundActivity $roundActivity)
    {
        $roundActivity->update($request->validated());

        return new RoundActivityResource($roundActivity);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RoundActivity $roundActivity)
    {
        $roundActivity->delete();

        return response()->noContent();
    }
}
