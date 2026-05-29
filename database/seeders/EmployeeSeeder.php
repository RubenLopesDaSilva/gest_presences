<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['name' => 'Sophie Martin', 'department' => 'Direction', 'rfid' => '00012345', 'status' => 'PRESENT'],
            ['name' => 'Thomas Dupont', 'department' => 'IT', 'rfid' => '00012346', 'status' => 'PRESENT'],
            ['name' => 'Marie Lefebvre', 'department' => 'RH', 'rfid' => '00012347', 'status' => 'ABSENT'],
            ['name' => 'Lucas Bernard', 'department' => 'Marketing', 'rfid' => '00012348', 'status' => 'PRESENT'],
            ['name' => 'Emma Petit', 'department' => 'Finance', 'rfid' => '00012349', 'status' => 'ABSENT'],
            ['name' => 'Alexandre Durand', 'department' => 'IT', 'rfid' => '00012350', 'status' => 'PRESENT'],
            ['name' => 'Léa Moreau', 'department' => 'Marketing', 'rfid' => '00012351', 'status' => 'PRESENT'],
            ['name' => 'Hugo Simon', 'department' => 'Ventes', 'rfid' => '00012352', 'status' => 'ABSENT'],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
