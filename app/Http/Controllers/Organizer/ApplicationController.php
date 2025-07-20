<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Opportunity;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    use ResponseTrait;

    public function index(Request $request, $opportunity_id)
    {
        $opportunity = Opportunity::where('id', $opportunity_id)
            ->where('organizer_id', $request->user()->id)
            ->first();

        if (!$opportunity) {
            return $this->error('Opportunity not found or not yours', 404);
        }

        $applications = Application::with(['volunteer:id,name,email'])
            ->where('opportunity_id', $opportunity_id)
            ->get();

        return $this->success($applications, 'Applications for your opportunity');
    }

    public function updateStatus(Request $request, Application $application)
    {
        $this->authorize('manage', $application);

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application->status = $request->status;
        $application->save();

        return $this->success($application, 'Application status updated');
    }
}
