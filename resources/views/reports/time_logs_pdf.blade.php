<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px; border: 1px solid #ddd; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Project</th>
                <th>User</th>
                <th>Hours</th>
                <th>Approved</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($timeLogs as $log)
                <tr>
                    <td>{{ $log->date?->format('Y-m-d') }}</td>
                    <td>{{ $log->project->client->name ?? 'N/A' }}</td>
                    <td>{{ $log->project->name ?? 'N/A' }}</td>
                    <td>{{ $log->user->name ?? 'N/A' }}</td>
                    <td>{{ number_format($log->hours, 2) }}</td>
                    <td>{{ $log->approved ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
