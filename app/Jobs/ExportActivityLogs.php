<?php

namespace App\Jobs;

use App\Models\ActivityLog;
use App\Models\Admin;
use App\Notifications\ActivityLogExportCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ExportActivityLogs implements ShouldQueue
{
    use Queueable;

    protected $admin;
    protected $filters;

    public function __construct(Admin $admin, array $filters = [])
    {
        $this->admin = $admin;
        $this->filters = $filters;
    }

    public function handle(): void
    {
        $query = ActivityLog::with('user');

        if (isset($this->filters['type'])) {
            $query->ofType($this->filters['type']);
        }

        if (isset($this->filters['user'])) {
            $query->byUser($this->filters['user']);
        }

        if (isset($this->filters['from_date']) && isset($this->filters['to_date'])) {
            $query->inDateRange($this->filters['from_date'], $this->filters['to_date']);
        }

        $logs = $query->latest()->get();

        $csv = $this->generateCsv($logs);
        $filename = 'activity-logs-' . now()->format('Y-m-d-His') . '.csv';
        Storage::put('exports/' . $filename, $csv);

        $this->admin->notify(new ActivityLogExportCompleted($filename));
    }

    protected function generateCsv($logs)
    {
        $headers = [
            'ID',
            'Type',
            'Description',
            'User',
            'IP Address',
            'User Agent',
            'Metadata',
            'Created At',
        ];

        $rows = [];
        foreach ($logs as $log) {
            $rows[] = [
                $log->id,
                $log->type,
                $log->description,
                $log->user ? $log->user->name : 'System',
                $log->ip_address,
                $log->user_agent,
                json_encode($log->metadata),
                $log->created_at->toDateTimeString(),
            ];
        }

        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, $headers);
        foreach ($rows as $row) {
            fputcsv($csv, $row);
        }
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        return $content;
    }
}
