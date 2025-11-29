<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $clientIds = $user->clients()->pluck('clients.id');

        $projects = Project::with('client')
            ->whereIn('client_id', $clientIds)
            ->latest()
            ->get();

        $timeLogs = $user->timeLogs()->with('project')->latest('date')->take(5)->get();
        $changeRequests = $user->changeRequests()->with('project')->latest()->take(5)->get();

        $stats = [
            'hours_logged' => $user->timeLogs()->sum('hours'),
            'pending_logs' => $user->timeLogs()->where('approved', false)->count(),
            'open_changes' => $user->changeRequests()->where('status', '!=', 'completed')->count(),
        ];

        return view('portal.dashboard', compact('projects', 'timeLogs', 'changeRequests', 'stats'));
    }
}
