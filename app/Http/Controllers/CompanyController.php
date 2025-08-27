<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'centrex_ip' => 'nullable|ip',
            'type' => 'required|in:main,subsidiary',
            'parent_id' => 'nullable|exists:companies,id'
        ]);

        // Vérifier que le client appartient à l'utilisateur
        if (Auth::user()->isAdmin()) {
            $client = Client::findOrFail($validated['client_id']);
        } else {
            $client = Auth::user()->clients()->findOrFail($validated['client_id']);
        }

        // Vérifier le parent si fourni
        if (isset($validated['parent_id'])) {
            $parent = Company::findOrFail($validated['parent_id']);
            if (!Auth::user()->isAdmin() && $parent->client->user_id !== Auth::id()) {
                abort(403, 'Accès non autorisé à cette société parente');
            }
        }

        $company = Company::create($validated);

        return response()->json([
            'message' => 'Société créée avec succès',
            'company' => $company
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'centrex_ip' => 'nullable|ip'
        ]);

        $company = $this->findCompanyWithPermission($id);
        $company->update($validated);

        return response()->json([
            'message' => 'Société mise à jour avec succès',
            'company' => $company
        ]);
    }

    public function destroy($id)
    {
        $company = $this->findCompanyWithPermission($id);
        $company->delete();

        return response()->json([
            'message' => 'Société supprimée avec succès'
        ]);
    }

    private function findCompanyWithPermission($id)
    {
        $company = Company::with('client')->findOrFail($id);
        
        if (!Auth::user()->isAdmin() && $company->client->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette société');
        }

        return $company;
    }
}