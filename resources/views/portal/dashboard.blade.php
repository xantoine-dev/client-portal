@extends('layouts.app')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Total hours logged</p>
                    <h4 class="mb-0">{{ number_format($stats['hours_logged'] ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Pending approvals</p>
                    <h4 class="mb-0">{{ $stats['pending_logs'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Open change requests</p>
                    <h4 class="mb-0">{{ $stats['open_changes'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Projects</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->client->name ?? 'N/A' }}</td>
                                <td><span class="badge text-bg-info text-capitalize">{{ $project->status }}</span></td>
                                <td>{{ $project->created_at?->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-3">No projects yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent time logs</span>
                    <a href="{{ route('portal.time-logs.index') }}" class="small">View all</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Project</th>
                                    <th>Hours</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($timeLogs as $log)
                                    <tr>
                                        <td>{{ $log->date?->format('Y-m-d') }}</td>
                                        <td>{{ $log->project->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($log->hours, 2) }}</td>
                                        <td>
                                            @if ($log->approved)
                                                <span class="badge text-bg-success">Approved</span>
                                            @else
                                                <span class="badge text-bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-3">No logs yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent change requests</span>
                    <a href="{{ route('portal.change-requests.index') }}" class="small">View all</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($changeRequests as $request)
                                    <tr>
                                        <td>{{ $request->project->name ?? 'N/A' }}</td>
                                        <td><span class="badge text-bg-secondary text-capitalize">{{ $request->status }}</span></td>
                                        <td>{{ $request->created_at?->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center py-3">No requests yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
