<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoundStoreRequest;
use App\Http\Requests\RoundUpdateRequest;
use App\Http\Resources\RoundCollection;
use App\Http\Resources\RoundResource;
use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\RoundCollection
     */
    public function index(Request $request)
    {
        $rounds = Round::all();

        return new RoundCollection($rounds);
    }

    /**
     * @param \App\Http\Requests\RoundStoreRequest $request
     * @return \App\Http\Resources\RoundResource
     */
    public function store(RoundStoreRequest $request)
    {
        $round = Round::create($request->validated());

        return new RoundResource($round);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Round $round
     * @return \App\Http\Resources\RoundResource
     */
    public function show(Request $request, Round $round)
    {
        return new RoundResource($round);
    }

    /**
     * @param \App\Http\Requests\RoundUpdateRequest $request
     * @param \App\Models\Round $round
     * @return \App\Http\Resources\RoundResource
     */
    public function update(RoundUpdateRequest $request, Round $round)
    {
        $round->update($request->validated());

        return new RoundResource($round);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Round $round
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Round $round)
    {
        $round->delete();

        return response()->noContent();
    }
}
