<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $presentEmployees = Employee::where('status', 'PRESENT')->count();
        $absentEmployees = Employee::where('status', 'ABSENT')->count();

        $recentLogs = AttendanceLog::with('employee')
            ->orderBy('timestamp', 'desc')
            ->limit(5)
            ->get();

        // Données pour le graphique (exemple statique - vous pouvez le rendre dynamique)
        $chartData = [
            ['time' => '08:00', 'entrees' => 1, 'sorties' => 0],
            ['time' => '09:00', 'entrees' => 5, 'sorties' => 1],
            ['time' => '10:00', 'entrees' => 2, 'sorties' => 0],
            ['time' => '11:00', 'entrees' => 0, 'sorties' => 2],
            ['time' => '12:00', 'entrees' => 0, 'sorties' => 4],
            ['time' => '13:00', 'entrees' => 4, 'sorties' => 0],
            ['time' => '14:00', 'entrees' => 2, 'sorties' => 0],
            ['time' => '15:00', 'entrees' => 1, 'sorties' => 0],
            ['time' => '16:00', 'entrees' => 0, 'sorties' => 1],
            ['time' => '17:00', 'entrees' => 0, 'sorties' => $presentEmployees],
        ];

        return view('dashboard', compact(
            'totalEmployees',
            'presentEmployees',
            'absentEmployees',
            'recentLogs',
            'chartData'
        ));
    }
}
