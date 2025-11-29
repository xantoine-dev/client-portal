@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Reports</h2>
        <div>
            <a href="{{ route('admin.reports.csv', $filters) }}" class="btn btn-outline-primary btn-sm">Export CSV</a>
            <a href="{{ route('admin.reports.pdf', $filters) }}" class="btn btn-outline-secondary btn-sm">Export PDF</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="client_id" class="form-label">Client</label>
                    <select id="client_id" name="client_id" class="form-select">
                        <option value="">All clients</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @selected(($filters['client_id'] ?? null) == $client->id)>{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="project_id" class="form-label">Project</label>
                    <select id="project_id" name="project_id" class="form-select">
                        <option value="">All projects</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" @selected(($filters['project_id'] ?? null) == $project->id)>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="approved" class="form-label">Approval</label>
                    <select id="approved" name="approved" class="form-select">
                        <option value="">Any</option>
                        <option value="1" @selected(($filters['approved'] ?? null) === '1')>Approved</option>
                        <option value="0" @selected(($filters['approved'] ?? null) === '0')>Pending</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Project</th>
                            <th>User</th>
                            <th>Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timeLogs as $log)
                            <tr>
                                <td>{{ $log->date?->format('Y-m-d') }}</td>
                                <td>{{ $log->project->client->name ?? 'N/A' }}</td>
                                <td>{{ $log->project->name ?? 'N/A' }}</td>
                                <td>{{ $log->user->name ?? 'N/A' }}</td>
                                <td>{{ number_format($log->hours, 2) }}</td>
                                <td>{{ $log->approved ? 'Approved' : 'Pending' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-3">No results for current filter.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $timeLogs->withQueryString()->links() }}
    </div>
@endsection
