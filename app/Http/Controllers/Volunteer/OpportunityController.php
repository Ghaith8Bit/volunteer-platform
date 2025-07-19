<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpportunityResource;
use App\Models\Opportunity;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $query = Opportunity::with(['category:id,name', 'organizer:id,name'])
            ->where('status', 'approved');

        // Apply filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $opportunities = $query->latest()->get();

        return $this->success(OpportunityResource::collection($opportunities), 'Filtered opportunities list');
    }

    public function show($id)
    {
        $opportunity = Opportunity::with(['category:id,name', 'organizer:id,name'])
            ->where('status', 'approved')
            ->find($id);

        if (!$opportunity) {
            return $this->error('Opportunity not found or not approved yet', 404);
        }

        return $this->success(new OpportunityResource($opportunity), 'Opportunity details');
    }
}
