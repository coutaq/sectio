<?php

namespace App\Http\Controllers\App\Models;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Models\RoundStoreRequest;
use App\Http\Requests\App\Models\RoundUpdateRequest;
use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rounds = Round::all();

        return view('round.index', compact('rounds'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('round.create');
    }

    /**
     * @param \App\Http\Requests\App\Models\RoundStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoundStoreRequest $request)
    {
        $round = Round::create($request->validated());

        $request->session()->flash('round.id', $round->id);

        return redirect()->route('round.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Round $round
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Round $round)
    {
        return view('round.show', compact('round'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Round $round
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Round $round)
    {
        return view('round.edit', compact('round'));
    }

    /**
     * @param \App\Http\Requests\App\Models\RoundUpdateRequest $request
     * @param \App\Models\Round $round
     * @return \Illuminate\Http\Response
     */
    public function update(RoundUpdateRequest $request, Round $round)
    {
        $round->update($request->validated());

        $request->session()->flash('round.id', $round->id);

        return redirect()->route('round.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Round $round
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Round $round)
    {
        $round->delete();

        return redirect()->route('round.index');
    }
}
