<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EquipmentController extends Controller
{
    /**
     * Crée un nouvel équipement
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'phone_number_id' => 'required|exists:phone_numbers,id',
            'name' => 'nullable|string|max:255',
            'type' => 'required|string',
            'extension' => 'nullable|string|max:10',
            'user_name' => 'nullable|string|max:255',
            'mac_address' => 'nullable|string|max:17',
        ]);

        // Générer automatiquement le nom si non fourni
        $name = $request->name;
        if (!$name) {
            $name = $request->type;
            if ($request->extension) {
                $name .= " ({$request->extension})";
            }
        }

        $equipment = Equipment::create([
            'phone_number_id' => $request->phone_number_id,
            'name' => $name,
            'type' => $request->type,
            'extension' => $request->extension,
            'user_name' => $request->user_name,
            'mac_address' => $request->mac_address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Équipement créé avec succès',
            'equipment' => $equipment->load('phoneNumber.company')
        ], 201);
    }

    /**
     * Met à jour un équipement
     */
    public function update(Request $request, $id): JsonResponse
    {
        $equipment = Equipment::findOrFail($id);
        
        $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'required|string',
            'extension' => 'nullable|string|max:10',
            'user_name' => 'nullable|string|max:255',
            'mac_address' => 'nullable|string|max:17',
        ]);

        // Regénérer le nom si nécessaire
        $name = $request->name;
        if (!$name) {
            $name = $request->type;
            if ($request->extension) {
                $name .= " ({$request->extension})";
            }
        }

        $equipment->update([
            'name' => $name,
            'type' => $request->type,
            'extension' => $request->extension,
            'user_name' => $request->user_name,
            'mac_address' => $request->mac_address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Équipement mis à jour avec succès',
            'equipment' => $equipment->load('phoneNumber.company')
        ]);
    }

    /**
     * Supprime un équipement
     */
    public function destroy($id): JsonResponse
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Équipement supprimé avec succès'
        ]);
    }

    /**
     * Retourne la liste des types d'équipements disponibles
     */
    public function getTypes(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'types' => Equipment::getEquipmentTypes()
        ]);
    }
}