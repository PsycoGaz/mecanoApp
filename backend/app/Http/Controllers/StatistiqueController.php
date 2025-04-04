<?php

namespace App\Http\Controllers;

use App\Models\Statistique;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Reparation;
use App\Models\Voiture;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    /**
     * Display all statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Statistique::all());
    }

    /**
     * Generate and return statistics dynamically.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateStats()
    {
        // Nombre total de réparations
        $nbReparations = Reparation::count();

        // Chiffre d'affaires total (somme des coûts des réparations)
        $caTotal = Reparation::sum('cout');

        // Top 3 clients en fonction du nombre de réparations effectuées
        $topClients = Client::select('clients.id', 'clients.nom', 'clients.prenom', DB::raw('COUNT(reparations.id) as total_reparations'))
            ->join('voitures', 'clients.id', '=', 'voitures.client_id')
            ->join('reparations', 'voitures.id', '=', 'reparations.voiture_id')
            ->groupBy('clients.id', 'clients.nom', 'clients.prenom')
            ->orderByDesc('total_reparations')
            ->limit(3)
            ->get();

        return response()->json([
            'nb_reparations' => $nbReparations,
            'ca_total' => $caTotal,
            'top_clients' => $topClients
        ]);
    }

    /**
     * Store a newly created statistic in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $statistique = Statistique::create($request->all());
        return response()->json($statistique, 201);
    }

    /**
     * Display a specific statistic.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Statistique::findOrFail($id));
    }

    /**
     * Update a specific statistic.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $statistique = Statistique::findOrFail($id);
        $statistique->update($request->all());
        return response()->json($statistique);
    }

    /**
     * Remove a statistic from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statistique = Statistique::findOrFail($id);
        $statistique->delete();
        return response()->json(['message' => 'Statistique supprimée avec succès']);
    }
}
