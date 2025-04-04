<?php

namespace App\Http\Controllers;

use App\Models\Reparation;
use Illuminate\Http\Request;

class ReparationController extends Controller
{
    /**
     * Display a listing of the reparations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all reparations
        $reparations = Reparation::with(['voiture', 'technicien', 'piece'])->get();
        return response()->json($reparations);
    }

    /**
     * Store a newly created reparation in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'cout' => 'required|numeric',
            'voiture_id' => 'required|exists:voitures,id',
            'technicien_id' => 'required|exists:employes,id',
            'piece_id' => 'sometimes|exists:piece_detachees,id',
        ]);

        // Create a new reparation
        $reparation = Reparation::create($validatedData);
        return response()->json($reparation, 201);
    }

    /**
     * Display the specified reparation.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the reparation by ID and load relationships
        $reparation = Reparation::with(['voiture', 'technicien', 'pieces'])->findOrFail($id);
        return response()->json($reparation);
    }

    /**
     * Update the specified reparation in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the reparation by ID
        $reparation = Reparation::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'cout' => 'required|numeric',
            'voiture_id' => 'required|exists:voitures,id',
            'technicien_id' => 'required|exists:employes,id',
            'piece_id' => 'sometimes|exists:piece_detachees,id',
        ]);

        // Update the reparation
        $reparation->update($validatedData);
        return response()->json($reparation);
    }

    /**
     * Remove the specified reparation from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the reparation by ID and delete it
        $reparation = Reparation::findOrFail($id);
        $reparation->delete();

        return response()->json(['message' => 'Reparation deleted successfully']);
    }
}
