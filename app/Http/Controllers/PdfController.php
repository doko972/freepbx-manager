<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    /**
     * Génère le rapport complet d'un client
     */
    public function generateClientReport($clientId)
    {
        // ÉTAPE 1: Récupérer le client avec ses relations
        $client = Client::with([
            'companies.subsidiaries.phoneNumbers.equipment',
            'companies.phoneNumbers.equipment'
        ])->findOrFail($clientId);

        // ÉTAPE 2: Calculer les totaux
        $totalEquipment = 0;
        $totalExtensions = 0;
        $totalPhoneNumbers = 0;

        foreach ($client->companies as $company) {
            // Compter les numéros de la société principale
            $totalPhoneNumbers += $company->phoneNumbers->count();
            
            foreach ($company->phoneNumbers as $phoneNumber) {
                foreach ($phoneNumber->equipment as $equipment) {
                    $totalEquipment++;
                    if ($equipment->extension) {
                        $totalExtensions++;
                    }
                }
            }

            // Compter les numéros des filiales
            foreach ($company->subsidiaries as $subsidiary) {
                $totalPhoneNumbers += $subsidiary->phoneNumbers->count();
                
                foreach ($subsidiary->phoneNumbers as $phoneNumber) {
                    foreach ($phoneNumber->equipment as $equipment) {
                        $totalEquipment++;
                        if ($equipment->extension) {
                            $totalExtensions++;
                        }
                    }
                }
            }
        }

        // ÉTAPE 3: Préparer les données pour la vue
        $data = [
            'client' => $client,
            'total_equipment_count' => $totalEquipment,
            'total_extensions_count' => $totalExtensions,
            'total_companies' => $client->companies->count(),
            'total_phone_numbers' => $totalPhoneNumbers,
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        // ÉTAPE 4: Générer le PDF
        $pdf = Pdf::loadView('pdf.client-report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'rapport-' . Str::slug($client->name) . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Génère la liste des équipements d'un client
     */
    public function generateEquipmentList($clientId)
    {
        $client = Client::with([
            'companies.subsidiaries.phoneNumbers.equipment',
            'companies.phoneNumbers.equipment'
        ])->findOrFail($clientId);

        // Collecte de tous les équipements
        $allEquipment = collect();

        foreach ($client->companies as $company) {
            $this->collectEquipment($company, $allEquipment);
        }

        $data = [
            'client' => $client,
            'equipment' => $allEquipment->sortBy('equipment.extension'), // Correction du tri
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.equipment-list', $data);
        $pdf->setPaper('A4', 'landscape'); // Paysage pour plus d'espace

        $filename = 'equipements-' . Str::slug($client->name) . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Collecte récursive des équipements
     */
    private function collectEquipment($company, &$collection)
    {
        foreach ($company->phoneNumbers as $phoneNumber) {
            foreach ($phoneNumber->equipment as $equipment) {
                $collection->push([
                    'equipment' => $equipment,
                    'phone_number' => $phoneNumber,
                    'company' => $company,
                ]);
            }
        }

        foreach ($company->subsidiaries as $subsidiary) {
            $this->collectEquipment($subsidiary, $collection);
        }
    }

    /**
     * Génère un rapport consolidé de tous les clients
     */
    public function generateGlobalReport()
    {
        $clients = Client::with([
            'companies.subsidiaries.phoneNumbers.equipment',
            'companies.phoneNumbers.equipment'
        ])->get(); // Supprimé where('is_active', true) si la colonne n'existe pas

        // Calculer les statistiques globales
        $totalStats = [
            'total_clients' => $clients->count(),
            'total_companies' => 0,
            'total_equipment' => 0,
            'total_extensions' => 0,
        ];

        // Calculer et ajouter les totaux pour chaque client
        foreach ($clients as $client) {
            $totalStats['total_companies'] += $client->companies->count();
            
            $clientEquipment = 0;
            $clientExtensions = 0;
            
            foreach ($client->companies as $company) {
                $this->countEquipmentAndExtensions($company, $clientEquipment, $clientExtensions);
            }
            
            // Ajouter les propriétés calculées au client pour l'affichage (méthode sécurisée)
            $client->setAttribute('total_equipment_count', $clientEquipment);
            $client->setAttribute('total_extensions_count', $clientExtensions);
            
            $totalStats['total_equipment'] += $clientEquipment;
            $totalStats['total_extensions'] += $clientExtensions;
        }

        $data = [
            'clients' => $clients,
            'stats' => $totalStats,
            'generated_at' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.global-report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'rapport-global-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Compter récursivement les équipements et extensions
     */
    private function countEquipmentAndExtensions($company, &$totalEquipment, &$totalExtensions)
    {
        foreach ($company->phoneNumbers as $phoneNumber) {
            foreach ($phoneNumber->equipment as $equipment) {
                $totalEquipment++;
                if ($equipment->extension) {
                    $totalExtensions++;
                }
            }
        }

        // Compter aussi les filiales récursivement
        foreach ($company->subsidiaries as $subsidiary) {
            $this->countEquipmentAndExtensions($subsidiary, $totalEquipment, $totalExtensions);
        }
    }
}