<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use App\Models\AttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    /**
     * Tableau de bord du professeur
     */
    public function dashboard()
    {
        $teacher = auth()->user();

        if (!$teacher || !$teacher->isTeacher()) {
            return redirect()->route('login');
        }

        // Récupérer les classes du professeur
        $classes = Classe::where('teacher_id', $teacher->id)->get();

        // Statistiques globales
        $totalStudents = User::where('role', 'student')
            ->whereIn('classe_id', $classes->pluck('id'))
            ->count();

        $presentStudents = User::where('role', 'student')
            ->whereIn('classe_id', $classes->pluck('id'))
            ->get()
            ->filter(function ($student) {
                return $student->status === 'PRESENT';
            })
            ->count();

        $absentStudents = $totalStudents - $presentStudents;

        // Activité récente
        $recentLogs = AttendanceLog::with('user.classe')
            ->whereHas('user', function ($query) use ($classes) {
                $query->whereIn('classe_id', $classes->pluck('id'));
            })
            ->whereDate('timestamp', today())
            ->orderBy('timestamp', 'desc')
            ->limit(10)
            ->get();

        return view('teacher.dashboard', compact(
            'teacher',
            'classes',
            'totalStudents',
            'presentStudents',
            'absentStudents',
            'recentLogs'
        ));
    }

    /**
     * Vue détaillée d'une classe
     */
    public function showClasse(Classe $classe)
    {
        $teacher = auth()->user();

        // Vérifier que le professeur a accès à cette classe
        if ($classe->teacher_id !== $teacher->id) {
            abort(403, 'Vous n\'avez pas accès à cette classe');
        }

        $students = $classe->students()
            ->orderBy('name')
            ->get()
            ->map(function ($student) {
                $student->current_status = $student->status;
                $student->today_logs = $student->attendanceLogs()
                    ->whereDate('timestamp', today())
                    ->orderBy('timestamp', 'desc')
                    ->get();
                return $student;
            });

        return view('teacher.classe', compact('classe', 'students'));
    }

    /**
     * Historique complet des présences
     */
    public function history(Request $request)
    {
        $teacher = auth()->user();
        $classes = Classe::where('teacher_id', $teacher->id)->get();

        $query = AttendanceLog::with('user.classe')
            ->whereHas('user', function ($q) use ($classes) {
                $q->whereIn('classe_id', $classes->pluck('id'));
            })
            ->orderBy('timestamp', 'desc');

        // Filtres
        if ($request->has('classe_id') && $request->classe_id) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('classe_id', $request->classe_id);
            });
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('timestamp', $request->date);
        }

        $logs = $query->paginate(50);

        return view('teacher.history', compact('logs', 'classes'));
    }

    /**
     * Gestion des élèves
     */
    public function students()
    {
        $teacher = auth()->user();
        $classes = Classe::where('teacher_id', $teacher->id)->get();

        $students = User::where('role', 'student')
            ->whereIn('classe_id', $classes->pluck('id'))
            ->with('classe')
            ->orderBy('name')
            ->paginate(20);

        return view('teacher.students', compact('students', 'classes'));
    }

    /**
     * Créer un nouvel élève
     */
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'rfid_code' => 'required|string|unique:users,rfid_code',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $validated['password'] = bcrypt('password'); // Mot de passe par défaut
        $validated['role'] = 'student';

        User::create($validated);

        return redirect()->back()->with('success', 'Élève ajouté avec succès');
    }

    /**
     * Supprimer un élève
     */
    public function destroyStudent(User $student)
    {
        $teacher = auth()->user();

        // Vérifier que l'élève appartient à une classe du professeur
        if ($student->classe->teacher_id !== $teacher->id) {
            abort(403);
        }

        $student->delete();

        return redirect()->back()->with('success', 'Élève supprimé avec succès');
    }
}
