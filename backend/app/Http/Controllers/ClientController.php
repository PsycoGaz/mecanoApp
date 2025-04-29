<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    // Get all clients with their cars
    public function index()
    {
        return response()->json(Client::with('voitures')->get());
    }

    // Store a new client
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'mdp' => 'required|string|max:255',
        'email' => 'required|email|unique:clients,email',
    ]);
    
    // Set default role if not provided
    $validatedData['role'] = $request->input('role', 'utilisateur');
    
    // Hash the password before saving
    $validatedData['mdp'] = bcrypt($validatedData['mdp']);
    
    $client = Client::create($validatedData);
    
    return response()->json($client, 201);
}
    // Show a specific client with their cars
    public function show($id)
    {
        $client = Client::with('voitures')->findOrFail($id);
        return response()->json($client);
    }

    // Update a client
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'mdp' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $id,
            'role' => 'required|string|max:255'
        ]);

        $client->update($validatedData);
        return response()->json($client);
    }

    // Delete a client (cascade deletes their cars)
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json(['message' => 'Client supprimé avec succès']);
    }
}
