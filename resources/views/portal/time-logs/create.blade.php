@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Log time</h2>
        <a href="{{ route('portal.time-logs.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('portal.time-logs.store') }}">
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
                    <label for="date" class="form-label">Date</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date', now()->toDateString()) }}" required>
                </div>
                <div class="mb-3">
                    <label for="hours" class="form-label">Hours</label>
                    <input type="number" step="0.25" min="0.25" max="24" id="hours" name="hours" class="form-control" value="{{ old('hours') }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit log</button>
                </div>
            </form>
        </div>
    </div>
@endsection
