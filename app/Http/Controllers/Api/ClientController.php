<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Affiche la liste de tous les clients
     */
    public function index(): JsonResponse
    {
        if (Auth::user()->isAdmin()) {
            $clients = Client::with(['companies.phoneNumbers.equipment', 'companies.subsidiaries.phoneNumbers.equipment'])
                ->get();
        } else {
            $clients = Auth::user()->clients()
                ->with(['companies.phoneNumbers.equipment', 'companies.subsidiaries.phoneNumbers.equipment'])
                ->get();
        }

        // Calculer les statistiques pour chaque client
        $clients->each(function ($client) {
            $client->companies_count = $client->companies->count();
            $client->phone_numbers_count = $client->companies->sum(function ($company) {
                return $company->phoneNumbers->count() + $company->subsidiaries->sum(function ($sub) {
                    return $sub->phoneNumbers->count();
                });
            });

            $equipmentCount = 0;
            $extensionsCount = 0;

            foreach ($client->companies as $company) {
                foreach ($company->phoneNumbers as $phone) {
                    $equipmentCount += $phone->equipment->count();
                    $extensionsCount += $phone->equipment->whereNotNull('extension')->count();
                }
                foreach ($company->subsidiaries as $subsidiary) {
                    foreach ($subsidiary->phoneNumbers as $phone) {
                        $equipmentCount += $phone->equipment->count();
                        $extensionsCount += $phone->equipment->whereNotNull('extension')->count();
                    }
                }
            }

            $client->equipment_count = $equipmentCount;
            $client->extensions_count = $extensionsCount;
        });

        return response()->json([
            'success' => true,
            'clients' => $clients
        ]);
    }

    /**
     * Crée un nouveau client
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $client = Client::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Client créé avec succès',
            'client' => $client
        ], 201);
    }

    /**
     * Affiche un client spécifique avec sa hiérarchie
     */
    public function show($id): JsonResponse
    {
        $client = Client::with([
            'companies' => function ($query) {
                $query->whereNull('parent_id')
                    ->with(['subsidiaries.phoneNumbers.equipment', 'phoneNumbers.equipment']);
            }
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'client' => $client,
            'hierarchy' => $client->companies->map(function ($company) {
                return $company->getHierarchyTree();
            }),
            'stats' => [
                'total_companies' => $client->companies->count(),
                'total_equipment' => $client->total_equipment_count,
                'total_extensions' => $client->total_extensions_count,
                'total_phone_numbers' => $client->total_phone_numbers_count,
            ]
        ]);
    }

    /**
     * Met à jour un client
     */
    public function update(Request $request, $id): JsonResponse
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $client->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Client mis à jour avec succès',
            'client' => $client
        ]);
    }

    /**
     * Supprime un client
     */
    public function destroy($id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client supprimé avec succès'
        ]);
    }
}
