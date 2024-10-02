<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    public function showLogs()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!file_exists($logPath)) {
            abort(404, 'Log file not found');
        }

        $logs = file_get_contents($logPath);

        return view('logs', ['logs' => $logs]);
    }

    public function clearLogs()
    {
        $logPath = storage_path('logs/laravel.log');

        if (file_exists($logPath)) {
            // Clear the log file
            file_put_contents($logPath, '');
        }

        // Redirect back to the logs page
        return redirect()->route('logs')->with('success', 'Logs cleared successfully.');
    }
}
