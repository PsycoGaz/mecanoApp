<?php

namespace App\Http\Controllers;

use App\Models\PieceDetachee;
use Illuminate\Http\Request;

class PieceDetacheeController extends Controller
{
    /**
     * Display a listing of the spare parts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all spare parts
        $pieces = PieceDetachee::all();
        return response()->json($pieces);
    }

    /**
     * Store a newly created spare part in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'reparation_id' => 'sometimes|exists:reparations,id',
        ]);

        // Create a new piece detachee (spare part)
        $piece = PieceDetachee::create($validatedData);
        return response()->json($piece, 201);
    }

    /**
     * Display the specified spare part.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find a specific spare part
        $piece = PieceDetachee::findOrFail($id);
        return response()->json($piece);
    }

    /**
     * Update the specified spare part in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the piece detachee (spare part) to update
        $piece = PieceDetachee::findOrFail($id);

        // Validate the request
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'reparation_id' => 'sometimes|exists:reparations,id',
        ]);

        // Update the piece detachee (spare part)
        $piece->update($validatedData);
        return response()->json($piece);
    }

    /**
     * Remove the specified spare part from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the piece detachee (spare part) to delete
        $piece = PieceDetachee::findOrFail($id);
        $piece->delete();

        return response()->json(['message' => 'Piece detachee deleted successfully']);
    }
}
