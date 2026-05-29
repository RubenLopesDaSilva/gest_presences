<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('scanner', compact('employees'));
    }

    public function scan(Request $request)
    {
        $request->validate([
            'rfid' => 'required|string',
        ]);

        $employee = Employee::where('rfid', $request->rfid)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Badge non reconnu. Accès refusé.',
            ], 404);
        }

        // Déterminer le type d'événement (IN ou OUT)
        $type = $employee->status === 'PRESENT' ? 'OUT' : 'IN';

        // Créer le log
        AttendanceLog::create([
            'employee_id' => $employee->id,
            'type' => $type,
            'timestamp' => now(),
        ]);

        // Basculer le statut de l'employé
        $employee->toggleStatus();

        return response()->json([
            'success' => true,
            'employee' => $employee,
            'type' => $type,
            'message' => $type === 'IN' ? 'Bienvenue !' : 'Au revoir !',
        ]);
    }
}
