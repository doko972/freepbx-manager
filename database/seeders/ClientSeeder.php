<?php
namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            [
                'name' => 'ACME Corporation',
                'email' => 'contact@acme-corp.fr',
                'phone' => '0123456789',
                'address' => '123 Rue de la Paix, 75001 Paris'
            ],
            [
                'name' => 'TechStart SARL',
                'email' => 'info@techstart.fr',
                'phone' => '0987654321',
                'address' => '456 Avenue des Champs, 69000 Lyon'
            ],
            [
                'name' => 'Global Solutions',
                'email' => 'admin@global-solutions.fr',
                'phone' => '0147258369',
                'address' => '789 Boulevard Central, 13000 Marseille'
            ]
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }
    }
}