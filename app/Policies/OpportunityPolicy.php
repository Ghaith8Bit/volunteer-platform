<?php

namespace App\Policies;

use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OpportunityPolicy
{
    public function manage(User $user, Opportunity $opportunity)
    {
        return $user->id === $opportunity->organizer_id;
    }
}
