<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
        return $application->user_id === $user->id;
    }

    public function delete(User $user, Application $application): bool
    {
        return $application->user_id === $user->id;
    }
}
