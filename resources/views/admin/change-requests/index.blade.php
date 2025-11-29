@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Review change requests</h2>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Client</th>
                            <th>Requested by</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($changeRequests as $request)
                            <tr>
                                <td>{{ $request->project->name ?? 'N/A' }}</td>
                                <td>{{ $request->project->client->name ?? 'N/A' }}</td>
                                <td>{{ $request->requester->name ?? 'N/A' }}</td>
                                <td>{{ $request->description }}</td>
                                <td><span class="badge text-bg-secondary text-capitalize">{{ $request->status }}</span></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.change-requests.update', $request) }}" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm me-2" style="max-width: 170px;">
                                            @foreach (['open' => 'Open', 'in_review' => 'In review', 'completed' => 'Completed'] as $value => $label)
                                                <option value="{{ $value }}" @selected($request->status === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-3">No change requests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
