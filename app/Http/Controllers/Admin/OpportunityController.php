<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpportunityResource;
use App\Models\Opportunity;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $opportunities = Opportunity::with(['category:id,name', 'organizer:id,name'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return $this->success(OpportunityResource::collection($opportunities), 'List of pending opportunities');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $opportunity = Opportunity::find($id);

        if (!$opportunity) {
            return $this->error('Opportunity not found', 404);
        }

        $opportunity->update(['status' => $request->status]);

        return $this->success([
            'id'     => $opportunity->id,
            'status' => $opportunity->status
        ], 'Opportunity status updated');
    }
}
