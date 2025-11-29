<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimeLogRequest;
use App\Models\Project;
use App\Models\TimeLog;
use App\Services\TimeLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeLogController extends Controller
{
    public function __construct(private readonly TimeLogService $service)
    {
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', TimeLog::class);
        $timeLogs = $this->service->listForClient($request->user());

        return view('portal.time-logs.index', compact('timeLogs'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', TimeLog::class);
        $projects = Project::whereIn('client_id', $request->user()->clients()->pluck('clients.id'))
            ->orderBy('name')
            ->get();

        return view('portal.time-logs.create', compact('projects'));
    }

    public function store(StoreTimeLogRequest $request): RedirectResponse
    {
        $this->service->createForClient($request->user(), $request->validated());

        return redirect()
            ->route('portal.time-logs.index')
            ->with('status', 'Time log submitted for review.');
    }
}
