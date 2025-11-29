<?php

namespace App\Policies;

use App\Models\TimeLog;
use App\Models\User;

class TimeLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff() || $user->isClient();
    }

    public function view(User $user, TimeLog $timeLog): bool
    {
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        return $user->id === $timeLog->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isClient();
    }

    public function update(User $user, TimeLog $timeLog): bool
    {
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        return $user->id === $timeLog->user_id && ! $timeLog->approved;
    }

    public function delete(User $user, TimeLog $timeLog): bool
    {
        return $this->update($user, $timeLog);
    }

    public function approve(User $user, TimeLog $timeLog): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }
}
