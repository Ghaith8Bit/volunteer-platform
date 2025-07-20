<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    use ResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'opportunity_id' => 'required|exists:opportunities,id',
        ]);

        $user = $request->user();

        $exists = Application::where('user_id', $user->id)
            ->where('opportunity_id', $request->opportunity_id)
            ->whereIn('status', ['pending', 'accepted'])
            ->whereHas('opportunity', function ($query) {
                $query->where('status', 'approved');
            })
            ->exists();

        if ($exists) {
            return $this->error('You have already applied to this opportunity.', 409);
        }

        $application = Application::create([
            'user_id'        => $user->id,
            'opportunity_id' => $request->opportunity_id,
            'status'         => 'pending',
        ]);

        $application->load(['opportunity.category', 'opportunity.organizer']);

        return $this->success(new ApplicationResource($application), 'Application submitted successfully');
    }

    public function mine(Request $request)
    {
        $applications = Application::with(['opportunity.category', 'opportunity.organizer'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return $this->success(ApplicationResource::collection($applications), 'Your submitted applications');
    }
}
