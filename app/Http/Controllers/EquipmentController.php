<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\MacAddress;

class EquipmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_number_id' => 'required|exists:phone_numbers,id',
            'type' => 'required|string|max:100',
            'extension' => 'nullable|string|max:20',
            'user_name' => 'nullable|string|max:255',
            'mac_address' => ['nullable', new MacAddress]
        ]);

        // Vérifier que le numéro appartient à l'utilisateur
        $phoneNumber = $this->findPhoneNumberWithPermission($validated['phone_number_id']);

        // Générer le nom automatiquement
        $validated['name'] = $this->generateEquipmentName($validated['type'], $validated['extension']);

        $equipment = Equipment::create($validated);

        return response()->json([
            'message' => 'Équipement créé avec succès',
            'equipment' => $equipment
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:100',
            'extension' => 'nullable|string|max:20',
            'user_name' => 'nullable|string|max:255',
            'mac_address' => ['nullable', new MacAddress]
        ]);

        $equipment = $this->findEquipmentWithPermission($id);

        // Mettre à jour le nom automatiquement
        $validated['name'] = $this->generateEquipmentName($validated['type'], $validated['extension']);

        $equipment->update($validated);

        return response()->json([
            'message' => 'Équipement mis à jour avec succès',
            'equipment' => $equipment
        ]);
    }

    public function destroy($id)
    {
        $equipment = $this->findEquipmentWithPermission($id);
        $equipment->delete();

        return response()->json([
            'message' => 'Équipement supprimé avec succès'
        ]);
    }

    private function findEquipmentWithPermission($id)
    {
        $equipment = Equipment::with('phoneNumber.company.client')->findOrFail($id);
        
        if (!Auth::user()->isAdmin() && $equipment->phoneNumber->company->client->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cet équipement');
        }

        return $equipment;
    }

    private function findPhoneNumberWithPermission($phoneNumberId)
    {
        $phoneNumber = PhoneNumber::with('company.client')->findOrFail($phoneNumberId);
        
        if (!Auth::user()->isAdmin() && $phoneNumber->company->client->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce numéro');
        }

        return $phoneNumber;
    }

    private function generateEquipmentName($type, $extension = null)
    {
        $name = $type;
        if ($extension) {
            $name .= " ({$extension})";
        }
        return $name;
    }
}