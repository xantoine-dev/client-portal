@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Review time logs</h2>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Project</th>
                            <th>Client</th>
                            <th>User</th>
                            <th>Hours</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timeLogs as $log)
                            <tr>
                                <td>{{ $log->date?->format('Y-m-d') }}</td>
                                <td>{{ $log->project->name ?? 'N/A' }}</td>
                                <td>{{ $log->project->client->name ?? 'N/A' }}</td>
                                <td>{{ $log->user->name ?? 'N/A' }}</td>
                                <td>{{ number_format($log->hours, 2) }}</td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @if ($log->approved)
                                        <span class="badge text-bg-success">Approved</span>
                                    @else
                                        <span class="badge text-bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.time-logs.update', $log) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="approved" value="1">
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.time-logs.update', $log) }}" class="d-inline ms-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="approved" value="0">
                                        <button class="btn btn-sm btn-outline-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-3">No time logs available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
