<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rapport Client - {{ $client->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(135deg, #1d46ef 0%, #0f2db3 100%);
            color: white;
            padding: 15px 30px;
            text-align: center;
            margin: 0;
        }

        .header h1 {
            font-size: 20px;
            margin: 0 0 8px 0;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 13px;
            opacity: 0.9;
            margin: 0 0 10px 0;
        }

        .header .company-info {
            font-size: 11px;
            opacity: 0.8;
            margin: 0;
        }

        .pdf-container {
            padding: 10px 30px;
        }

        .client-overview {
            background: #f8faff;
            border: 2px solid #1d46ef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }

        .overview-title {
            font-size: 16px;
            font-weight: bold;
            color: #1d46ef;
            margin-bottom: 15px;
            text-align: center;
        }

        .overview-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .overview-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
            width: 25%;
        }

        .overview-number {
            font-size: 24px;
            font-weight: bold;
            color: #1d46ef;
            display: block;
            margin-bottom: 5px;
        }

        .overview-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .client-info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        .client-info-table th {
            background: #e2e8f0;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #374151;
            font-size: 11px;
        }

        .client-info-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1d46ef;
            margin: 25px 0 15px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #1d46ef;
        }

        .company-section {
            margin: 20px 0;
            break-inside: avoid;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }

        .company-header {
            background: #1d46ef;
            color: white;
            padding: 12px 18px;
            font-weight: bold;
            font-size: 14px;
        }

        .company-info {
            padding: 12px 18px;
            background: #f8faff;
            border-bottom: 1px solid #e2e8f0;
        }

        .company-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .company-info td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11px;
        }

        .company-info .label {
            font-weight: bold;
            color: #64748b;
            width: 20%;
        }

        .phone-list {
            padding: 12px 18px;
        }

        .phone-item {
            margin: 8px 0;
            padding: 10px;
            background: #ffffff;
            border-left: 3px solid #10b981;
            border-radius: 3px;
        }

        .phone-number {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .equipment-grid {
            display: table;
            width: 100%;
            margin-top: 8px;
        }

        .equipment-item {
            display: table-cell;
            padding: 6px 12px 6px 0;
            width: 33.33%;
            vertical-align: top;
        }

        .equipment-card {
            background: #f8faff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px;
            margin-right: 8px;
        }

        .equipment-type {
            font-weight: bold;
            color: #1d46ef;
            font-size: 11px;
            margin-bottom: 4px;
        }

        .equipment-details {
            font-size: 10px;
            color: #64748b;
        }

        .extension-highlight {
            background: #10b981;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 9px;
            font-weight: bold;
        }

        .subsidiary-section {
            margin: 15px 0 0 20px;
            padding: 12px;
            background: #fafbfc;
            border-left: 3px solid #f59e0b;
            border-radius: 3px;
        }

        .subsidiary-header {
            font-weight: bold;
            color: #f59e0b;
            margin-bottom: 8px;
            font-size: 12px;
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
            font-size: 11px;
            line-height: 1.6;
        }

        .recommendations-content h4 {
            color: #1d46ef;
            margin: 12px 0 6px 0;
            font-size: 12px;
        }

        .recommendations-content ul {
            margin: 4px 0 12px 18px;
            padding: 0;
        }

        .recommendations-content li {
            margin-bottom: 4px;
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

        @page {
            margin: 0;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📊 RAPPORT CLIENT DÉTAILLÉ</h1>
        <p class="subtitle">Analyse complète de l'infrastructure - {{ $client->name }}</p>
        <div class="company-info">
            <strong>HR TELECOMS</strong> | Généré le {{ $generated_at }}
        </div>
    </div>

    <div class="pdf-container">
        <!-- Vue d'ensemble -->
        <div class="client-overview">
            <div class="overview-title">VUE D'ENSEMBLE</div>
            <div class="overview-grid">
                <div class="overview-item">
                    <span class="overview-number">{{ $client->companies->count() }}</span>
                    <span class="overview-label">Sociétés</span>
                </div>
                <div class="overview-item">
                    <span
                        class="overview-number">{{ $client->companies->sum(function ($c) {return $c->phoneNumbers->count() +$c->subsidiaries->sum(function ($s) {return $s->phoneNumbers->count();});}) }}</span>
                    <span class="overview-label">Numéros</span>
                </div>
                <div class="overview-item">
                    <span class="overview-number">{{ $total_equipment_count }}</span>
                    <span class="overview-label">Équipements</span>
                </div>
                <div class="overview-item">
                    <span class="overview-number">{{ $total_extensions_count }}</span>
                    <span class="overview-label">Extensions</span>
                </div>
            </div>
        </div>

        <!-- Informations client -->
        @if ($client->email || $client->phone || $client->address)
            <h2 class="section-title">INFORMATIONS CLIENT</h2>
            <table class="client-info-table">
                @if ($client->email)
                    <tr>
                        <th style="width: 20%;">Email</th>
                        <td>{{ $client->email }}</td>
                    </tr>
                @endif
                @if ($client->phone)
                    <tr>
                        <th>Téléphone</th>
                        <td>{{ $client->phone }}</td>
                    </tr>
                @endif
                @if ($client->address)
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $client->address }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Date de création</th>
                    <td>{{ $client->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        @endif

        <!-- Structure organisationnelle -->
        <h2 class="section-title">STRUCTURE ORGANISATIONNELLE</h2>

        @foreach ($client->companies->where('type', 'main') as $company)
            <div class="company-section">
                <div class="company-header">
                    🏢 SOCIÉTÉ PRINCIPALE: {{ strtoupper($company->name) }}
                </div>

                <div class="company-info">
                    <table>
                        @if ($company->centrex_ip)
                            <tr>
                                <td class="label">IP Centrex:</td>
                                <td>{{ $company->centrex_ip }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="label">Numéros de téléphone:</td>
                            <td>{{ $company->phoneNumbers->count() }}</td>
                        </tr>
                        <tr>
                            <td class="label">Filiales:</td>
                            <td>{{ $company->subsidiaries->count() }}</td>
                        </tr>
                        <tr>
                            <td class="label">Créée le:</td>
                            <td>{{ $company->created_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>

                @if ($company->phoneNumbers->count() > 0)
                    <div class="phone-list">
                        @foreach ($company->phoneNumbers as $phone)
                            <div class="phone-item">
                                <div class="phone-number">📞 {{ $phone->number }}</div>

                                @if ($phone->equipment->count() > 0)
                                    <div class="equipment-grid">
                                        @foreach ($phone->equipment->chunk(3) as $equipmentChunk)
                                            @foreach ($equipmentChunk as $equipment)
                                                <div class="equipment-item">
                                                    <div class="equipment-card">
                                                        <div class="equipment-type">{{ $equipment->type }}</div>
                                                        <div class="equipment-details">
                                                            @if ($equipment->extension)
                                                                Ext: <span
                                                                    class="extension-highlight">{{ $equipment->extension }}</span><br>
                                                            @endif
                                                            @if ($equipment->user_name)
                                                                Utilisateur: {{ $equipment->user_name }}
                                                            @else
                                                                <em style="color: #ef4444;">Non assigné</em>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @else
                                    <div style="color: #64748b; font-style: italic; font-size: 10px;">
                                        Aucun équipement associé
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Filiales -->
                @foreach ($company->subsidiaries as $subsidiary)
                    <div class="subsidiary-section">
                        <div class="subsidiary-header">🏬 FILIALE: {{ $subsidiary->name }}</div>

                        @if ($subsidiary->centrex_ip)
                            <div style="font-size: 10px; color: #64748b; margin-bottom: 8px;">
                                IP Centrex: {{ $subsidiary->centrex_ip }}
                            </div>
                        @endif

                        @if ($subsidiary->phoneNumbers->count() > 0)
                            <div style="margin-left: 15px;">
                                @foreach ($subsidiary->phoneNumbers as $phone)
                                    <div class="phone-item">
                                        <div class="phone-number">📞 {{ $phone->number }}</div>

                                        @if ($phone->equipment->count() > 0)
                                            <div class="equipment-grid">
                                                @foreach ($phone->equipment->chunk(3) as $equipmentChunk)
                                                    @foreach ($equipmentChunk as $equipment)
                                                        <div class="equipment-item">
                                                            <div class="equipment-card">
                                                                <div class="equipment-type">{{ $equipment->type }}
                                                                </div>
                                                                <div class="equipment-details">
                                                                    @if ($equipment->extension)
                                                                        Ext: <span
                                                                            class="extension-highlight">{{ $equipment->extension }}</span><br>
                                                                    @endif
                                                                    @if ($equipment->user_name)
                                                                        Utilisateur: {{ $equipment->user_name }}
                                                                    @else
                                                                        <em style="color: #ef4444;">Non assigné</em>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        @else
                                            <div style="color: #64748b; font-style: italic; font-size: 10px;">
                                                Aucun équipement associé
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="color: #64748b; font-style: italic; font-size: 10px;">
                                Aucun numéro de téléphone
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach

        @if ($client->companies->count() === 0)
            <div style="text-align: center; padding: 40px; color: #64748b; background: #f8faff; border-radius: 8px;">
                <h3 style="color: #1d46ef; margin-bottom: 10px;">Aucune société</h3>
                <p>Aucune société n'a été configurée pour ce client.</p>
            </div>
        @endif

        <!-- Recommandations -->
        <div class="recommendations">
            <div class="recommendations-title">ANALYSE ET RECOMMANDATIONS</div>
            <div class="recommendations-content">
                <h4>POINTS POSITIFS :</h4>
                <ul>
                    <li>{{ $client->companies->count() }} société(s) configurée(s)</li>
                    <li>{{ $total_equipment_count }} équipement(s) déployé(s)</li>
                    @if ($total_extensions_count > 0)
                        <li>{{ $total_extensions_count }} extension(s) configurée(s)</li>
                    @endif
                </ul>

                @if ($total_equipment_count > $total_extensions_count)
                    <h4>POINTS D'AMÉLIORATION :</h4>
                    <ul>
                        <li>{{ $total_equipment_count - $total_extensions_count }} équipement(s) sans extension
                            assignée</li>
                        @if (
                            $client->companies->sum(function ($c) {
                                return $c->phoneNumbers->sum(function ($p) {
                                    return $p->equipment->where('user_name', null)->count();
                                });
                            }) > 0)
                            <li>Plusieurs équipements ne sont pas assignés à un utilisateur</li>
                        @endif
                    </ul>
                @endif

                <h4>RECOMMANDATIONS TECHNIQUES :</h4>
                <ul>
                    <li>Vérifier régulièrement l'assignation des extensions</li>
                    <li>Documenter tous les utilisateurs d'équipements</li>
                    <li>Maintenir à jour les informations de contact</li>
                    @if ($client->companies->where('centrex_ip', null)->count() > 0)
                        <li>Configurer les adresses IP Centrex manquantes</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="left">© {{ date('Y') }} HR TELECOMS - Document Confidentiel</div>
        <div class="right">FreePBX Manager - Rapport Client - Page {PAGE_NUM}</div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>
