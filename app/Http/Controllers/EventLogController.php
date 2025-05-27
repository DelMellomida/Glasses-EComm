<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventLog;

class EventLogController extends Controller
{
    public function index()
    {
        // Eager load user for display
        $logs = EventLog::with('user')->orderByDesc('created_at')->paginate(20);
        return view('admin.event-logs', compact('logs'));
    }
}
