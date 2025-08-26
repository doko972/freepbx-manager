<?php
namespace Database\Seeders;

use App\Models\Company;
use App\Models\Client;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $client1 = Client::where('name', 'ACME Corporation')->first();
        $client2 = Client::where('name', 'TechStart SARL')->first();

        // Sociétés principales
        $acmeMain = Company::create([
            'client_id' => $client1->id,
            'name' => 'ACME Corp Siège',
            'centrex_ip' => '192.168.1.100',
            'type' => 'main'
        ]);

        $techMain = Company::create([
            'client_id' => $client2->id,
            'name' => 'TechStart Lyon',
            'centrex_ip' => '192.168.2.100',
            'type' => 'main'
        ]);

        // Filiales
        Company::create([
            'client_id' => $client1->id,
            'name' => 'ACME Paris',
            'centrex_ip' => '192.168.1.101',
            'type' => 'subsidiary',
            'parent_id' => $acmeMain->id
        ]);

        Company::create([
            'client_id' => $client1->id,
            'name' => 'ACME Marseille',
            'centrex_ip' => '192.168.1.102',
            'type' => 'subsidiary',
            'parent_id' => $acmeMain->id
        ]);
    }
}