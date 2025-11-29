@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Change Requests</h2>
        <a href="{{ route('portal.change-requests.create') }}" class="btn btn-primary">Submit request</a>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($changeRequests as $request)
                            <tr>
                                <td>{{ $request->project->name ?? 'N/A' }}</td>
                                <td>{{ $request->description }}</td>
                                <td><span class="badge text-bg-secondary text-capitalize">{{ $request->status }}</span></td>
                                <td>{{ $request->created_at?->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-3">No change requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
