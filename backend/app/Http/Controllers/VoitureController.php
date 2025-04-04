<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index()
    {
        return response()->json(Voiture::all());
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'required|integer|min:1900|max:'.date('Y'),
            'client_id' => 'required|exists:clients,id',
        ]);

        $voiture = Voiture::create($validated);
        return response()->json($voiture, 201);
    }

    /**
     * Display the specified car.
     */
    public function show($id)
    {
        return response()->json(Voiture::findOrFail($id));
    }

    /**
     * Update the specified car in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'marque' => 'sometimes|string|max:255',
            'modele' => 'sometimes|string|max:255',
            'annee' => 'sometimes|integer|min:1900|max:'.date('Y'),
            'client_id' => 'sometimes|exists:clients,id',
        ]);

        $voiture = Voiture::findOrFail($id);
        $voiture->update($validated);
        return response()->json($voiture);
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy($id)
    {
        $voiture = Voiture::findOrFail($id);
        $voiture->delete();
        return response()->json(['message' => 'Voiture supprimée avec succès']);
    }
}
