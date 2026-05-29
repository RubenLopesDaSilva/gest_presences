<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'rfid' => 'required|string|unique:employees,rfid',
        ]);

        $employee = Employee::create([
            'name' => $validated['name'],
            'department' => $validated['department'],
            'rfid' => $validated['rfid'],
            'status' => 'ABSENT',
        ]);

        return redirect()->route('employees')->with('success', 'Employé ajouté avec succès.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees')->with('success', 'Employé supprimé avec succès.');
    }
}
