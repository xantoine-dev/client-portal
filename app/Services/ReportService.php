<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Collection;
use League\Csv\Writer;

class ReportService
{
    public function timeLogsCsv(Collection $timeLogs): string
    {
        $csv = Writer::createFromString();
        $csv->insertOne(['Project', 'Client', 'User', 'Date', 'Hours', 'Approved']);

        foreach ($timeLogs as $log) {
            $csv->insertOne([
                $log->project->name ?? 'N/A',
                $log->project->client->name ?? 'N/A',
                $log->user->name ?? 'N/A',
                optional($log->date)->format('Y-m-d'),
                $log->hours,
                $log->approved ? 'Yes' : 'No',
            ]);
        }

        return $csv->toString();
    }

    public function timeLogsPdf(Collection $timeLogs, string $title = 'Time Logs'): string
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $html = view('reports.time_logs_pdf', [
            'timeLogs' => $timeLogs,
            'title' => $title,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->render();

        return $dompdf->output();
    }
}
