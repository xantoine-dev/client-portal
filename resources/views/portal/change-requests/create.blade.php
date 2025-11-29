@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Submit change request</h2>
        <a href="{{ route('portal.change-requests.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('portal.change-requests.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="project_id" class="form-label">Project</label>
                    <select id="project_id" name="project_id" class="form-select" required>
                        <option value="">Select project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Describe the change</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit request</button>
                </div>
            </form>
        </div>
    </div>
@endsection
