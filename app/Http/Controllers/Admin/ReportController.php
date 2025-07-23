<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $reports = Report::with([
            'reporter:id,name,role',
            'user:id,name,role',
            'opportunity:id,title,location'
        ])->latest()->get();

        return $this->success($reports, 'List of all reports');
    }

    public function show($id)
    {
        $report = Report::with([
            'reporter:id,name,role',
            'user:id,name,role',
            'opportunity:id,title,location'
        ])->find($id);

        if (!$report) {
            return $this->error('Report not found', 404);
        }

        return $this->success($report, 'Report details');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,dismissed'
        ]);

        $report = Report::find($id);

        if (!$report) {
            return $this->error('Report not found', 404);
        }

        $report->status = $request->status;
        $report->save();

        return $this->success($report, 'Report status updated successfully');
    }
}
