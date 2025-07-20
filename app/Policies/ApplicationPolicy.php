<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    public function manage(User $user, Application $application)
    {
        return $application->opportunity->organizer_id === $user->id;
    }
}
