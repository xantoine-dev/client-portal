<?php

namespace App\Services;

use App\Models\Project;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TimeLogService
{
    public function listForClient(User $user): Collection
    {
        return TimeLog::with(['project.client', 'approver'])
            ->where('user_id', $user->id)
            ->latest('date')
            ->get();
    }

    public function listForStaff(): Collection
    {
        return TimeLog::with(['project.client', 'user'])
            ->latest('date')
            ->get();
    }

    public function createForClient(User $user, array $data): TimeLog
    {
        $project = $this->getProjectForUser($user, (int) $data['project_id']);

        if (! $project) {
            throw new HttpException(403, 'Project does not belong to your account.');
        }

        return TimeLog::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'date' => $data['date'],
            'hours' => $data['hours'],
            'description' => $data['description'],
        ]);
    }

    public function approve(TimeLog $timeLog, User $approver, bool $approved): TimeLog
    {
        $timeLog->approved = $approved;
        $timeLog->approved_by = $approved ? $approver->id : null;
        $timeLog->save();

        return $timeLog;
    }

    public function getProjectForUser(User $user, int $projectId): ?Project
    {
        return Project::where('id', $projectId)
            ->whereIn('client_id', $user->clients()->pluck('clients.id'))
            ->first();
    }
}
