<?php

namespace App\Http\Controllers;

use App\Models\PieceDetachee;
use App\Models\Reparation;
use Illuminate\Http\Request;

class ReparationController extends Controller
{
    /**
     * Display a listing of the reparations.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     // Get all reparations
    //     $reparations = Reparation::with(['voiture', 'technicien', 'piece',])->get();
    //     return response()->json($reparations);
    // }

    public function index()
{
    // Charger toutes les réparations avec les relations voiture, technicien et pieces
    $reparations = Reparation::with(['voiture', 'technicien', 'pieces'])->get();
    return response()->json($reparations);
}

    /**
     * Store a newly created reparation in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'date' => 'required|date',
    //         'cout' => 'required|numeric',
    //         'voiture_id' => 'required|exists:voitures,id',
    //         'km' => 'required|integer',
    //         'technicien_id' => 'required|exists:employes,id',
    //         'piece_id' => 'sometimes|exists:piece_detachees,id',
    //     ]);

    //     // Create a new reparation
    //     $reparation = Reparation::create($validatedData);
    //     return response()->json($reparation, 201);
    // }
    // public function store(Request $request)
    // {
    //     $reparation = Reparation::create($request->only(['date', 'cout', 'km', 'voiture_id', 'technicien_id']));
    
    //     if ($request->has('pieces')) {
    //         $reparation->pieces()->attach($request->pieces);
    //     }
    
    //     return response()->json($reparation->load(['voiture', 'technicien', 'pieces']));
    // }
 
    public function store(Request $request)
    {
        // Create the reparation
        $reparation = Reparation::create($request->only(['date', 'cout', 'km', 'voiture_id', 'technicien_id']));
    
        // Verify that all pieces exist in the `piece_detachees` table
        $piecesExistantes = PieceDetachee::whereIn('id', $request->pieces)->pluck('id')->toArray();
    
        // If all pieces are valid, attach them
        if (count($piecesExistantes) == count($request->pieces)) {
            $reparation->pieces()->attach($request->pieces);
        } else {
            return response()->json(['error' => 'Une ou plusieurs pièces n\'existent pas'], 400);
        }
    
        // Loop through the pieces and update their stock
        foreach ($request->pieces as $pieceId) {
            $piece = PieceDetachee::find($pieceId);
    
            // Check if the piece exists and has sufficient stock
            if ($piece && $piece->qtestock > 0) {
                $piece->qtestock -= 1; // Decrease stock by 1
                $piece->save(); // Save the updated stock
            } else {
                return response()->json(['error' => 'La pièce n\'existe pas ou le stock est insuffisant'], 400);
            }
        }
    
        // Return the created reparation with its relationships
        return response()->json($reparation->load(['voiture', 'technicien', 'pieces']));
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
            'km' => 'required|integer',
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

    public function getByCarId($carId)
    {
        // Fetch reparations associated with the given car ID
        $reparations = Reparation::with(['voiture', 'technicien', 'pieces'])
            ->where('voiture_id', $carId)
            ->get();

        // Return the reparations as a JSON response
        return response()->json($reparations);
    }
}
