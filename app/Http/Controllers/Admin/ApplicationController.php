<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $applications = Application::with([
            'volunteer:id,name,email',
            'opportunity:id,title',
            'opportunity.organizer:id,name',
            'opportunity.category:id,name',
        ])->latest()->get();

        return $this->success(ApplicationResource::collection($applications), 'All applications');
    }

    public function show(Application $application)
    {
        $application->load([
            'volunteer:id,name,email',
            'opportunity:id,title,location,start_date,end_date',
            'opportunity.organizer:id,name',
            'opportunity.category:id,name',
        ]);

        return $this->success(new ApplicationResource($application), 'Application details');
    }
}
