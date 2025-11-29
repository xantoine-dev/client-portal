<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveTimeLogRequest;
use App\Models\TimeLog;
use App\Services\TimeLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeLogReviewController extends Controller
{
    public function __construct(private readonly TimeLogService $service)
    {
    }

    public function index(): View
    {
        $this->authorize('viewAny', TimeLog::class);
        $timeLogs = $this->service->listForStaff();

        return view('admin.time-logs.index', compact('timeLogs'));
    }

    public function update(ApproveTimeLogRequest $request, TimeLog $timeLog): RedirectResponse
    {
        $this->authorize('approve', $timeLog);
        $this->service->approve($timeLog, $request->user(), (bool) $request->validated()['approved']);

        return back()->with('status', 'Time log review saved.');
    }
}
