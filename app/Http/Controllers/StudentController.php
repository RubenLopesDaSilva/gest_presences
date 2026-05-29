<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Affiche l'interface de scan pour les élèves
     */
    public function scanner()
    {
        return view('student.scanner');
    }

    /**
     * Traite le scan du badge RFID
     */
    public function scan(Request $request)
    {
        $request->validate([
            'rfid_code' => 'required|string'
        ]);

        $user = User::where('rfid_code', $request->rfid_code)
            ->where('role', 'student')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Badge non reconnu'
            ], 404);
        }

        // Déterminer l'action (ENTREE ou SORTIE) basée sur le dernier log
        $lastLog = $user->attendanceLogs()
            ->whereDate('timestamp', today())
            ->latest('timestamp')
            ->first();

        $action = (!$lastLog || $lastLog->action === 'SORTIE') ? 'ENTREE' : 'SORTIE';

        // Créer le log d'attendance
        $log = AttendanceLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'timestamp' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $action === 'ENTREE' ? 'Bienvenue !' : 'À bientôt !',
            'student' => [
                'name' => $user->name,
                'classe' => $user->classe ? $user->classe->name : 'Non assigné',
                'action' => $action,
                'timestamp' => $log->timestamp->format('H:i:s')
            ]
        ]);
    }

    /**
     * Affiche le tableau de bord personnel de l'élève
     */
    public function dashboard()
    {
        $user = auth()->user();

        if (!$user || !$user->isStudent()) {
            return redirect()->route('login');
        }

        $todayLogs = $user->attendanceLogs()
            ->whereDate('timestamp', today())
            ->orderBy('timestamp', 'desc')
            ->get();

        $weekLogs = $user->attendanceLogs()
            ->whereBetween('timestamp', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('timestamp', 'desc')
            ->get();

        $status = $user->status;

        return view('student.dashboard', compact('user', 'todayLogs', 'weekLogs', 'status'));
    }
}
