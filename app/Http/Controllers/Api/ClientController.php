<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Affiche la liste de tous les clients
     */
    public function index(): JsonResponse
    {
        $clients = Client::with(['companies.phoneNumbers.equipment'])
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();

        return response()->json([
            'success' => true,
            'clients' => $clients->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'address' => $client->address,
                    'companies_count' => $client->companies->count(),
                    'equipment_count' => $client->total_equipment_count,
                    'extensions_count' => $client->total_extensions_count,
                    'phone_numbers_count' => $client->total_phone_numbers_count,
                    'created_at' => $client->created_at,
                    'updated_at' => $client->updated_at,
                ];
            })
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
