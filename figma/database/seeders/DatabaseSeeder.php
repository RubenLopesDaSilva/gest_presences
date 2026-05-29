<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Classe;
use App\Models\AttendanceLog;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un professeur
        $teacher = User::create([
            'name' => 'M. Dupont',
            'email' => 'prof@ecole.fr',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Créer des classes
        $classe1 = Classe::create([
            'name' => 'Terminale S1',
            'level' => 'Terminale',
            'teacher_id' => $teacher->id,
        ]);

        $classe2 = Classe::create([
            'name' => 'Première ES2',
            'level' => 'Première',
            'teacher_id' => $teacher->id,
        ]);

        // Créer des élèves pour la première classe
        $students1 = [
            ['name' => 'Jean Martin', 'email' => 'jean.martin@ecole.fr', 'rfid' => 'RFID001'],
            ['name' => 'Marie Dubois', 'email' => 'marie.dubois@ecole.fr', 'rfid' => 'RFID002'],
            ['name' => 'Pierre Leroy', 'email' => 'pierre.leroy@ecole.fr', 'rfid' => 'RFID003'],
            ['name' => 'Sophie Bernard', 'email' => 'sophie.bernard@ecole.fr', 'rfid' => 'RFID004'],
            ['name' => 'Lucas Petit', 'email' => 'lucas.petit@ecole.fr', 'rfid' => 'RFID005'],
        ];

        foreach ($students1 as $studentData) {
            $student = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'rfid_code' => $studentData['rfid'],
                'classe_id' => $classe1->id,
            ]);

            // Créer quelques logs de test pour certains élèves
            if (rand(0, 1)) {
                AttendanceLog::create([
                    'user_id' => $student->id,
                    'action' => 'ENTREE',
                    'timestamp' => now()->setHour(8)->setMinute(rand(0, 30)),
                ]);
            }
        }

        // Créer des élèves pour la deuxième classe
        $students2 = [
            ['name' => 'Emma Moreau', 'email' => 'emma.moreau@ecole.fr', 'rfid' => 'RFID006'],
            ['name' => 'Hugo Simon', 'email' => 'hugo.simon@ecole.fr', 'rfid' => 'RFID007'],
            ['name' => 'Chloé Laurent', 'email' => 'chloe.laurent@ecole.fr', 'rfid' => 'RFID008'],
            ['name' => 'Nathan Girard', 'email' => 'nathan.girard@ecole.fr', 'rfid' => 'RFID009'],
        ];

        foreach ($students2 as $studentData) {
            $student = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'rfid_code' => $studentData['rfid'],
                'classe_id' => $classe2->id,
            ]);

            // Créer quelques logs de test
            if (rand(0, 1)) {
                AttendanceLog::create([
                    'user_id' => $student->id,
                    'action' => 'ENTREE',
                    'timestamp' => now()->setHour(8)->setMinute(rand(0, 30)),
                ]);
            }
        }

        $this->command->info('Données de test créées avec succès !');
        $this->command->info('Professeur: prof@ecole.fr / password');
        $this->command->info('Élève (exemple): jean.martin@ecole.fr / password');
        $this->command->info('Code RFID test: RFID001 à RFID009');
    }
}
