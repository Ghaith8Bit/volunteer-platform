<?php

namespace App\Http\Controllers\Volunteer;


use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Review;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewController extends Controller
{
    use ResponseTrait;

    public function store(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
            'rating'         => 'required|integer|min:1|max:5',
            'review_text'    => 'nullable|string|max:1000',
        ]);

        $user = $request->user();

        $application = Application::with('opportunity')
            ->where('id', $request->application_id)
            ->where('user_id', $user->id)
            ->where('status', 'accepted')
            ->first();

        if (!$application) {
            return $this->error('You are not authorized to review this opportunity.', 403);
        }

        if (Carbon::parse($application->opportunity->end_date)->isFuture()) {
            return $this->error('You can only review after the opportunity ends.', 422);
        }

        if ($application->review) {
            return $this->error('You have already submitted a review.', 409);
        }

        $review = Review::create([
            'application_id' => $application->id,
            'rating'         => $request->rating,
            'review_text'    => $request->review_text,
        ]);

        return $this->success($review, 'Review submitted successfully', 201);
    }
}
