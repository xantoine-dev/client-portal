<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeLog;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $service)
    {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['client_id', 'project_id', 'approved']);
        $timeLogs = $this->query($filters)->paginate(15);

        $clients = Client::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();

        return view('admin.reports.index', compact('timeLogs', 'clients', 'projects', 'filters'));
    }

    public function csv(Request $request): Response
    {
        $timeLogs = $this->query($request->only(['client_id', 'project_id', 'approved']))->get();
        $csv = $this->service->timeLogsCsv($timeLogs);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="time-logs.csv"',
        ]);
    }

    public function pdf(Request $request): Response
    {
        $timeLogs = $this->query($request->only(['client_id', 'project_id', 'approved']))->get();
        $pdf = $this->service->timeLogsPdf($timeLogs, 'Time Logs');

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="time-logs.pdf"',
        ]);
    }

    protected function query(array $filters)
    {
        return TimeLog::with(['project.client', 'user'])
            ->when($filters['client_id'] ?? null, function ($query, $clientId) {
                $query->whereHas('project', fn ($q) => $q->where('client_id', $clientId));
            })
            ->when($filters['project_id'] ?? null, function ($query, $projectId) {
                $query->where('project_id', $projectId);
            })
            ->when(isset($filters['approved']) && $filters['approved'] !== '', function ($query) use ($filters) {
                $query->where('approved', filter_var($filters['approved'], FILTER_VALIDATE_BOOL));
            })
            ->orderByDesc('date');
    }
}
