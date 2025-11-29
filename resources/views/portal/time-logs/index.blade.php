@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Time Logs</h2>
        <a href="{{ route('portal.time-logs.create') }}" class="btn btn-primary">Add time log</a>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Project</th>
                            <th>Hours</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timeLogs as $log)
                            <tr>
                                <td>{{ $log->date?->format('Y-m-d') }}</td>
                                <td>{{ $log->project->name ?? 'N/A' }}</td>
                                <td>{{ number_format($log->hours, 2) }}</td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @if ($log->approved)
                                        <span class="badge text-bg-success">Approved</span>
                                    @else
                                        <span class="badge text-bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-3">No time logs yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
