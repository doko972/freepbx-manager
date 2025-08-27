<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rapport Global - HRTélécoms</title>
    <style>
        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #2c3e50;
            margin: 0 !important;
            padding: 0 !important;
        }

        .header {
            background: linear-gradient(135deg, #1d46ef 0%, #0f2db3 100%);
            color: white;
            padding: 15px 30px;
            text-align: center;
            margin: 0;
            margin-top: 0 !important;
        }

        .header h1 {
            font-size: 22px;
            margin: 0 0 8px 0;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 13px;
            opacity: 0.9;
            margin: 0 0 12px 0;
        }

        .header .company-info {
            font-size: 11px;
            opacity: 0.8;
            margin: 0;
        }

        .pdf-container {
            padding: 10px 30px;
            margin-top: 0;
        }

        .summary-section {
            background: #f8faff;
            border: 2px solid #1d46ef;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            color: #1d46ef;
            margin-bottom: 15px;
        }

        .summary-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 8px;
            width: 25%;
        }

        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #1d46ef;
            display: block;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1d46ef;
            margin: 25px 0 15px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #1d46ef;
        }

        .client-section {
            margin: 20px 0;
            break-inside: avoid;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }

        .client-header {
            background: #1d46ef;
            color: white;
            padding: 12px 18px;
            font-weight: bold;
            font-size: 14px;
        }

        .client-info {
            padding: 12px 18px;
            background: #f8faff;
            border-bottom: 1px solid #e2e8f0;
        }

        .client-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .client-info td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11px;
        }

        .client-info .label {
            font-weight: bold;
            color: #64748b;
            width: 20%;
        }

        .client-stats {
            padding: 12px 18px;
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .client-stats .stat-item {
            display: table-cell;
            text-align: center;
            padding: 8px;
            width: 25%;
        }

        .client-stats .stat-item .number {
            font-size: 16px;
            font-weight: bold;
            color: #1d46ef;
            display: block;
        }

        .client-stats .stat-item .label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .companies-list {
            padding: 12px 18px;
        }

        .company-item {
            margin: 8px 0;
            padding: 10px;
            background: #ffffff;
            border-left: 3px solid #1d46ef;
            border-radius: 3px;
        }

        .company-name {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .company-details {
            font-size: 10px;
            color: #64748b;
        }

        .company-details span {
            margin-right: 12px;
        }

        .subsidiary-item {
            margin: 6px 0 0 15px;
            font-size: 10px;
            color: #64748b;
        }

        .equipment-summary {
            margin: 20px 0;
            padding: 15px;
            background: #f0f8ff;
            border-radius: 6px;
        }

        .equipment-summary h4 {
            color: #1d46ef;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .equipment-table th {
            background: #1d46ef;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .equipment-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }

        .equipment-table tbody tr:nth-child(even) {
            background: #f8faff;
        }

        .recommendations {
            background: #f8faff;
            border: 2px solid #1d46ef;
            border-radius: 8px;
            padding: 18px;
            margin: 25px 0;
        }

        .recommendations-title {
            font-size: 14px;
            font-weight: bold;
            color: #1d46ef;
            margin-bottom: 12px;
        }

        .recommendations-content {
            text-align: left;
            font-size: 10px;
            line-height: 1.5;
        }

        .recommendations-content p {
            margin: 8px 0;
            font-weight: bold;
        }

        .recommendations-content ul {
            margin: 4px 0 12px 18px;
            padding: 0;
        }

        .recommendations-content li {
            margin-bottom: 3px;
            font-weight: normal;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #2c3e50;
            color: white;
            padding: 6px 30px;
            text-align: center;
            font-size: 9px;
            left: 0;
            right: 0;
        }

        .footer .left {
            float: left;
        }

        .footer .right {
            float: right;
        }

        /* MARGES CORRIGÉES - PLUS DE CONTENU EN HAUT */
        @page {
            margin: 0;
        }

        .page-break {
            page-break-before: always;
        }

        /* Suppression des espaces inutiles */
        .pdf-container:first-child {
            padding-top: 15px;
        }

        /* Optimisation de l'espace */
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>RAPPORT GLOBAL D'INFRASTRUCTURE</h1>
        <p class="subtitle">Vue d'ensemble de tous les clients - FreePBX Manager</p>
        <div class="company-info">
            <strong>HR TELECOMS</strong> | Généré le {{ $generated_at }}
        </div>
    </div>

    <div class="pdf-container">
        <!-- Statistiques globales -->
        <div class="summary-section">
            <div class="summary-title">RÉSUMÉ EXÉCUTIF</div>
            <div class="summary-grid">
                <div class="summary-item">
                    <span class="summary-number">{{ $stats['total_clients'] }}</span>
                    <span class="summary-label">Clients Actifs</span>
                </div>
                <div class="summary-item">
                    <span class="summary-number">{{ $stats['total_companies'] }}</span>
                    <span class="summary-label">Sociétés</span>
                </div>
                <div class="summary-item">
                    <span class="summary-number">{{ $stats['total_equipment'] }}</span>
                    <span class="summary-label">Équipements</span>
                </div>
                <div class="summary-item">
                    <span class="summary-number">{{ $stats['total_extensions'] }}</span>
                    <span class="summary-label">Extensions</span>
                </div>
            </div>
        </div>

        <!-- Liste des clients -->
        <h2 class="section-title">DÉTAIL PAR CLIENT</h2>

        @foreach ($clients as $client)
            <div class="client-section">
                <div class="client-header">
                    {{ strtoupper($client->name) }}
                </div>

                @if ($client->email || $client->phone || $client->address)
                    <div class="client-info">
                        <table>
                            @if ($client->email)
                                <tr>
                                    <td class="label">Email:</td>
                                    <td>{{ $client->email }}</td>
                                </tr>
                            @endif
                            @if ($client->phone)
                                <tr>
                                    <td class="label">Téléphone:</td>
                                    <td>{{ $client->phone }}</td>
                                </tr>
                            @endif
                            @if ($client->address)
                                <tr>
                                    <td class="label">Adresse:</td>
                                    <td>{{ $client->address }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endif

                <div class="client-stats">
                    <div class="stat-item">
                        <span class="number">{{ $client->companies->count() }}</span>
                        <span class="label">Sociétés</span>
                    </div>
                    <div class="stat-item">
                        <span
                            class="number">{{ $client->companies->sum(function ($c) {return $c->phoneNumbers->count();}) }}</span>
                        <span class="label">Numéros</span>
                    </div>
                    <div class="stat-item">
                        <span class="number">{{ $client->total_equipment_count }}</span>
                        <span class="label">Équipements</span>
                    </div>
                    <div class="stat-item">
                        <span class="number">{{ $client->total_extensions_count }}</span>
                        <span class="label">Extensions</span>
                    </div>
                </div>

                @if ($client->companies->count() > 0)
                    <div class="companies-list">
                        @foreach ($client->companies->where('type', 'main') as $company)
                            <div class="company-item">
                                <div class="company-name">SOCIÉTÉ PRINCIPALE: {{ $company->name }}</div>
                                <div class="company-details">
                                    @if ($company->centrex_ip)
                                        <span><strong>IP Centrex:</strong> {{ $company->centrex_ip }}</span>
                                    @endif
                                    <span><strong>Numéros:</strong> {{ $company->phoneNumbers->count() }}</span>
                                    <span><strong>Équipements:</strong>
                                        {{ $company->phoneNumbers->sum(function ($p) {return $p->equipment->count();}) }}</span>
                                    @if ($company->subsidiaries->count() > 0)
                                        <span><strong>Filiales:</strong> {{ $company->subsidiaries->count() }}</span>
                                    @endif
                                </div>

                                @if ($company->subsidiaries->count() > 0)
                                    @foreach ($company->subsidiaries as $subsidiary)
                                        <div class="subsidiary-item">
                                            <strong>FILIALE:</strong> {{ $subsidiary->name }}
                                            @if ($subsidiary->centrex_ip)
                                                | IP: {{ $subsidiary->centrex_ip }}
                                            @endif
                                            | {{ $subsidiary->phoneNumbers->count() }} numéro(s)
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        @if ($clients->count() === 0)
            <div style="text-align: center; padding: 40px; color: #64748b; background: #f8faff; border-radius: 8px;">
                <h3 style="color: #1d46ef; margin-bottom: 10px;">Aucun client actif</h3>
                <p>Aucune donnée à afficher pour le moment.</p>
            </div>
        @endif

        <!-- Analyse des types d'équipements -->
        @php
            $equipmentTypes = [];
            foreach ($clients as $client) {
                foreach ($client->companies as $company) {
                    foreach ($company->phoneNumbers as $phone) {
                        foreach ($phone->equipment as $equipment) {
                            $type = $equipment->type;
                            $equipmentTypes[$type] = ($equipmentTypes[$type] ?? 0) + 1;
                        }
                    }
                    foreach ($company->subsidiaries as $subsidiary) {
                        foreach ($subsidiary->phoneNumbers as $phone) {
                            foreach ($phone->equipment as $equipment) {
                                $type = $equipment->type;
                                $equipmentTypes[$type] = ($equipmentTypes[$type] ?? 0) + 1;
                            }
                        }
                    }
                }
            }
            arsort($equipmentTypes);
        @endphp

        @if (count($equipmentTypes) > 0)
            <div class="page-break"></div>
            <h2 class="section-title">ANALYSE DES ÉQUIPEMENTS</h2>

            <div class="equipment-summary">
                <h4>Répartition par Type d'Équipement</h4>
                <table class="equipment-table">
                    <thead>
                        <tr>
                            <th>Type d'Équipement</th>
                            <th style="text-align: center;">Quantité</th>
                            <th style="text-align: center;">Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipmentTypes as $type => $count)
                            <tr>
                                <td>{{ $type }}</td>
                                <td style="text-align: center; font-weight: bold;">{{ $count }}</td>
                                <td style="text-align: center; font-weight: bold;">
                                    {{ round(($count / array_sum($equipmentTypes)) * 100, 1) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Recommandations -->
        <div class="recommendations">
            <div class="recommendations-title">RECOMMANDATIONS</div>
            <div class="recommendations-content">
                <p>POINTS POSITIFS :</p>
                <ul>
                    <li>{{ $stats['total_clients'] }} client(s) actif(s) dans le système</li>
                    <li>{{ $stats['total_equipment'] }} équipements déployés et documentés</li>
                    <li>Infrastructure centralisée avec gestion hiérarchique</li>
                </ul>

                @if ($stats['total_extensions'] < $stats['total_equipment'])
                    <p>AMÉLIORATIONS SUGGÉRÉES :</p>
                    <ul>
                        <li>{{ $stats['total_equipment'] - $stats['total_extensions'] }} équipement(s) sans extension
                            assignée détecté(s)</li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="left">© {{ date('Y') }} HR TELECOMS - Document Confidentiel</div>
        <div class="right">FreePBX Manager v 1.0.0 - Page {PAGE_NUM}</div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>
