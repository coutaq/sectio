<?php

namespace App\Http\Controllers\App\Models;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Models\RoundActivityStoreRequest;
use App\Http\Requests\App\Models\RoundActivityUpdateRequest;
use App\Models\RoundActivity;
use Illuminate\Http\Request;

class RoundActivityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roundActivities = RoundActivity::all();

        return view('roundActivity.index', compact('roundActivities'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('roundActivity.create');
    }

    /**
     * @param \App\Http\Requests\App\Models\RoundActivityStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoundActivityStoreRequest $request)
    {
        $roundActivity = RoundActivity::create($request->validated());

        $request->session()->flash('roundActivity.id', $roundActivity->id);

        return redirect()->route('roundActivity.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RoundActivity $roundActivity)
    {
        return view('roundActivity.show', compact('roundActivity'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RoundActivity $roundActivity)
    {
        return view('roundActivity.edit', compact('roundActivity'));
    }

    /**
     * @param \App\Http\Requests\App\Models\RoundActivityUpdateRequest $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \Illuminate\Http\Response
     */
    public function update(RoundActivityUpdateRequest $request, RoundActivity $roundActivity)
    {
        $roundActivity->update($request->validated());

        $request->session()->flash('roundActivity.id', $roundActivity->id);

        return redirect()->route('roundActivity.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RoundActivity $roundActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RoundActivity $roundActivity)
    {
        $roundActivity->delete();

        return redirect()->route('roundActivity.index');
    }
}
