<?php

namespace App\Policies;

use App\Models\ChangeRequest;
use App\Models\User;

class ChangeRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff() || $user->isClient();
    }

    public function view(User $user, ChangeRequest $changeRequest): bool
    {
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        return $changeRequest->requested_by === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isClient();
    }

    public function update(User $user, ChangeRequest $changeRequest): bool
    {
        if ($user->isAdmin() || $user->isStaff()) {
            return true;
        }

        return $changeRequest->requested_by === $user->id && $changeRequest->status === 'open';
    }

    public function delete(User $user, ChangeRequest $changeRequest): bool
    {
        return $this->update($user, $changeRequest);
    }
}
