<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'reason'         => 'required|string|max:1000',
            'user_id'        => 'nullable|exists:users,id',
            'opportunity_id' => 'nullable|exists:opportunities,id',
        ]);

        if (!$request->user_id && !$request->opportunity_id) {
            return $this->error('You must report either a user or an opportunity.', 422);
        }

        if ($request->user_id && $request->opportunity_id) {
            return $this->error('You can only report one entity at a time.', 422);
        }

        $report = Report::create([
            'reporter_id'    => $request->user()->id,
            'reason'         => $request->reason,
            'user_id'        => $request->user_id,
            'opportunity_id' => $request->opportunity_id,
            'status'         => 'pending',
        ]);

        return $this->success($report, 'Report submitted successfully', 201);
    }
}
