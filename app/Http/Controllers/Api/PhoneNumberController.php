<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PhoneNumberController extends Controller
{
    /**
     * Crée un nouveau numéro de téléphone
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'number' => 'required|string|max:20',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $phoneNumber = PhoneNumber::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Numéro créé avec succès',
            'phone_number' => $phoneNumber->load('company')
        ], 201);
    }

    /**
     * Met à jour un numéro de téléphone
     */
    public function update(Request $request, $id): JsonResponse
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        
        $request->validate([
            'number' => 'required|string|max:20',
            'type' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $phoneNumber->update($request->only(['number', 'type', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Numéro mis à jour avec succès',
            'phone_number' => $phoneNumber->load('company')
        ]);
    }

    /**
     * Supprime un numéro de téléphone
     */
    public function destroy($id): JsonResponse
    {
        $phoneNumber = PhoneNumber::findOrFail($id);
        $phoneNumber->delete();

        return response()->json([
            'success' => true,
            'message' => 'Numéro supprimé avec succès'
        ]);
    }
}