<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $opportunities = $request->user()->opportunities()->with('category')->latest()->get();
        return $this->success($opportunities, 'List of your opportunities');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $opportunity = Opportunity::create([
            'organizer_id' => $request->user()->id,
            'title'        => $request->title,
            'description'  => $request->description,
            'location'     => $request->location,
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
            'category_id'  => $request->category_id,
            'status'       => 'pending'
        ]);

        return $this->success($opportunity, 'Opportunity created and pending admin approval', 201);
    }

    public function show(Opportunity $opportunity)
    {
        $this->authorize('manage', $opportunity);

        $opportunity->load('category');

        return $this->success($opportunity, 'Opportunity details');
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $this->authorize('manage', $opportunity);

        $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'location'    => 'sometimes|required|string',
            'start_date'  => 'sometimes|required|date',
            'end_date'    => 'sometimes|required|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $opportunity->update($request->only([
            'title',
            'description',
            'location',
            'start_date',
            'end_date',
            'category_id'
        ]));

        return $this->success($opportunity, 'Opportunity updated');
    }
}
