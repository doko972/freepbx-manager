<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneNumberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'number' => 'required|string|max:20',
            'type' => 'required|in:landline,mobile,toll-free,premium',
            'description' => 'nullable|string|max:500'
        ]);

        // Vérifier que la société appartient à l'utilisateur
        $company = $this->findCompanyWithPermission($validated['company_id']);

        $phoneNumber = PhoneNumber::create($validated);

        return response()->json([
            'message' => 'Numéro de téléphone créé avec succès',
            'phone_number' => $phoneNumber
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:20',
            'type' => 'required|in:landline,mobile,toll-free,premium',
            'description' => 'nullable|string|max:500'
        ]);

        $phoneNumber = $this->findPhoneNumberWithPermission($id);
        $phoneNumber->update($validated);

        return response()->json([
            'message' => 'Numéro mis à jour avec succès',
            'phone_number' => $phoneNumber
        ]);
    }

    public function destroy($id)
    {
        $phoneNumber = $this->findPhoneNumberWithPermission($id);
        $phoneNumber->delete();

        return response()->json([
            'message' => 'Numéro supprimé avec succès'
        ]);
    }

    private function findPhoneNumberWithPermission($id)
    {
        $phoneNumber = PhoneNumber::with('company.client')->findOrFail($id);
        
        if (!Auth::user()->isAdmin() && $phoneNumber->company->client->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à ce numéro');
        }

        return $phoneNumber;
    }

    private function findCompanyWithPermission($companyId)
    {
        $company = Company::with('client')->findOrFail($companyId);
        
        if (!Auth::user()->isAdmin() && $company->client->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette société');
        }

        return $company;
    }
}