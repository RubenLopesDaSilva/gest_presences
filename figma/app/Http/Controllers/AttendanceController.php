<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $logs = AttendanceLog::with('employee')
            ->orderBy('timestamp', 'desc')
            ->get();

        return view('history', compact('logs'));
    }
}
