<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Crée une nouvelle société
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'centrex_ip' => 'nullable|ip',
            'type' => 'required|in:main,subsidiary',
            'parent_id' => 'nullable|exists:companies,id',
        ]);

        $company = Company::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Société créée avec succès',
            'company' => $company->load(['parent', 'client'])
        ], 201);
    }

    /**
     * Met à jour une société
     */
    public function update(Request $request, $id): JsonResponse
    {
        $company = Company::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'centrex_ip' => 'nullable|ip',
        ]);

        $company->update($request->only(['name', 'centrex_ip']));

        return response()->json([
            'success' => true,
            'message' => 'Société mise à jour avec succès',
            'company' => $company->load(['parent', 'client'])
        ]);
    }

    /**
     * Supprime une société
     */
    public function destroy($id): JsonResponse
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Société supprimée avec succès'
        ]);
    }
}