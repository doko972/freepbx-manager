<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
   

        if (Auth::user()->isAdmin()) {
            // Admin voit tous les clients
            $clients = Client::with(['companies.phoneNumbers.equipment', 'companies.subsidiaries.phoneNumbers.equipment'])
                           ->get();
        } else {
            // User voit seulement ses clients
            $clients = Auth::user()->clients()
                          ->with(['companies.phoneNumbers.equipment', 'companies.subsidiaries.phoneNumbers.equipment'])
                          ->get();
        }

        // Calculer les statistiques pour chaque client
        $clients->each(function ($client) {
            $client->companies_count = $client->companies->count();
            $client->phone_numbers_count = $client->companies->sum(function($company) {
                return $company->phoneNumbers->count() + $company->subsidiaries->sum(function($sub) {
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
            'clients' => $clients,
            'user_role' => Auth::user()->role
        ]);
    }

    public function show($id)
    {
        if (Auth::user()->isAdmin()) {
            $client = Client::with(['companies.phoneNumbers.equipment', 'companies.subsidiaries.phoneNumbers.equipment'])
                          ->findOrFail($id);
        } else {
            // Vérifier que le client appartient à l'utilisateur
            $client = Auth::user()->clients()
                         ->with(['companies.phoneNumbers.equipment', 'companies.subsidiaries.phoneNumbers.equipment'])
                         ->findOrFail($id);
        }

        // Construire la hiérarchie
        $hierarchy = $this->buildHierarchy($client);

        return response()->json([
            'client' => $client,
            'hierarchy' => $hierarchy
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        // Créer le client lié à l'utilisateur connecté
        $client = Auth::user()->clients()->create($validated);

        return response()->json([
            'message' => 'Client créé avec succès',
            'client' => $client
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string'
        ]);

        if (Auth::user()->isAdmin()) {
            $client = Client::findOrFail($id);
        } else {
            // Vérifier que le client appartient à l'utilisateur
            $client = Auth::user()->clients()->findOrFail($id);
        }

        $client->update($validated);

        return response()->json([
            'message' => 'Client mis à jour avec succès',
            'client' => $client
        ]);
    }

    public function destroy($id)
    {
        if (Auth::user()->isAdmin()) {
            $client = Client::findOrFail($id);
        } else {
            // Vérifier que le client appartient à l'utilisateur
            $client = Auth::user()->clients()->findOrFail($id);
        }

        $client->delete();

        return response()->json([
            'message' => 'Client supprimé avec succès'
        ]);
    }

    private function buildHierarchy($client)
    {
        return $client->companies->where('type', 'main')->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'type' => $company->type,
                'centrex_ip' => $company->centrex_ip,
                'phone_numbers' => $company->phoneNumbers->map(function ($phone) {
                    return [
                        'id' => $phone->id,
                        'number' => $phone->number,
                        'type' => $phone->type,
                        'equipment' => $phone->equipment->map(function ($equipment) {
                            return [
                                'id' => $equipment->id,
                                'name' => $equipment->name,
                                'type' => $equipment->type,
                                'extension' => $equipment->extension,
                                'user_name' => $equipment->user_name
                            ];
                        })
                    ];
                }),
                'subsidiaries' => $company->subsidiaries->map(function ($subsidiary) {
                    return [
                        'id' => $subsidiary->id,
                        'name' => $subsidiary->name,
                        'type' => $subsidiary->type,
                        'centrex_ip' => $subsidiary->centrex_ip,
                        'phone_numbers' => $subsidiary->phoneNumbers->map(function ($phone) {
                            return [
                                'id' => $phone->id,
                                'number' => $phone->number,
                                'type' => $phone->type,
                                'equipment' => $phone->equipment->map(function ($equipment) {
                                    return [
                                        'id' => $equipment->id,
                                        'name' => $equipment->name,
                                        'type' => $equipment->type,
                                        'extension' => $equipment->extension,
                                        'user_name' => $equipment->user_name
                                    ];
                                })
                            ];
                        })
                    ];
                })
            ];
        })->values();
    }
}