<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Scanner RFID (accessible sans connexion)
Route::get('/', [StudentController::class, 'scanner'])->name('student.scanner');
Route::post('/api/scan', [StudentController::class, 'scan'])->name('student.scan');

// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Routes pour les élèves (authentification requise)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes pour les professeurs (authentification requise)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {
    // Tableau de bord
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');

    // Vue détaillée d'une classe
    Route::get('/classe/{classe}', [TeacherController::class, 'showClasse'])->name('classe');

    // Gestion des élèves
    Route::get('/students', [TeacherController::class, 'students'])->name('students');
    Route::post('/students', [TeacherController::class, 'storeStudent'])->name('students.store');
    Route::delete('/students/{student}', [TeacherController::class, 'destroyStudent'])->name('students.destroy');

    // Historique
    Route::get('/history', [TeacherController::class, 'history'])->name('history');
});
