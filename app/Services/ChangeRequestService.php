<?php

namespace App\Services;

use App\Models\ChangeRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChangeRequestService
{
    public function listForClient(User $user): Collection
    {
        return ChangeRequest::with('project.client')
            ->where('requested_by', $user->id)
            ->latest()
            ->get();
    }

    public function listForStaff(): Collection
    {
        return ChangeRequest::with(['project.client', 'requester'])
            ->latest()
            ->get();
    }

    public function createForClient(User $user, array $data): ChangeRequest
    {
        $project = $this->getProjectForUser($user, (int) $data['project_id']);

        if (! $project) {
            throw new HttpException(403, 'Project does not belong to your account.');
        }

        return ChangeRequest::create([
            'project_id' => $project->id,
            'requested_by' => $user->id,
            'description' => $data['description'],
            'status' => 'open',
        ]);
    }

    public function updateStatus(ChangeRequest $changeRequest, string $status): ChangeRequest
    {
        $changeRequest->status = $status;
        $changeRequest->save();

        return $changeRequest;
    }

    protected function getProjectForUser(User $user, int $projectId): ?Project
    {
        return Project::where('id', $projectId)
            ->whereIn('client_id', $user->clients()->pluck('clients.id'))
            ->first();
    }
}
