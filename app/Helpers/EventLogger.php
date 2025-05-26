<?php

namespace App\Helpers;

use App\Models\EventLog;
use Illuminate\Support\Facades\Auth;

class EventLogger
{
    public static function log($eventType, $description = null, $data = [])
    {
        EventLog::create([
            'user_id' => Auth::id(),
            'event_type' => $eventType,
            'description' => $description,
            'data' => $data ? json_encode($data) : null,
        ]);
    }
}
