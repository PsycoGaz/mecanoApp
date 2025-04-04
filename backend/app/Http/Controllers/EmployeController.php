<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    // Get all employees with their repairs
    public function index()
    {
        return response()->json(Employe::with('reparations')->get());
    }

    // Store a new employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'salaire' => 'required|numeric|min:0'
        ]);

        $employe = Employe::create($validatedData);
        return response()->json($employe, 201);
    }

    // Show a specific employee with their repairs
    public function show($id)
    {
        $employe = Employe::with('reparations')->findOrFail($id);
        return response()->json($employe);
    }

    // Update an employee
    public function update(Request $request, $id)
    {
        $employe = Employe::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'poste' => 'sometimes|string|max:255',
            'salaire' => 'sometimes|numeric|min:0'
        ]);

        $employe->update($validatedData);
        return response()->json($employe);
    }

    // Delete an employee (will also remove their assigned repairs)
    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);
        $employe->delete();

        return response()->json(['message' => 'Employé supprimé avec succès']);
    }
}
