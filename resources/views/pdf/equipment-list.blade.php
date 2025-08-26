<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Liste des Équipements - {{ $client->name }}</title>
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
            margin: 0;
        }

        .pdf-container {
            padding: 10px 30px;
        }

        .client-info-section {
            background: #f8faff;
            border: 2px solid #1d46ef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }

        .client-info-title {
            font-size: 14px;
            font-weight: bold;
            color: #1d46ef;
            margin-bottom: 10px;
        }

        .client-details {
            display: table;
            width: 100%;
        }

        .client-detail-item {
            display: table-cell;
            padding: 5px 10px;
            width: 25%;
        }

        .detail-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .detail-value {
            font-weight: bold;
            color: #1d46ef;
        }

        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .equipment-table th {
            background: #1d46ef;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        .equipment-table td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            vertical-align: top;
        }

        .equipment-table tbody tr:nth-child(even) {
            background: #f8faff;
        }

        .extension-badge {
            background: #10b981;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-family: 'Courier New', monospace;
            font-size: 9px;
            font-weight: bold;
        }

        .company-badge {
            background: #3b82f6;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }

        .type-badge {
            background: #f59e0b;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .phone-badge {
            background: #8b5cf6;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-family: 'Courier New', monospace;
        }

        .no-extension {
            color: #ef4444;
            font-style: italic;
            font-size: 9px;
        }

        .equipment-summary {
            margin: 20px 0;
            padding: 15px;
            background: #f0f8ff;
            border-radius: 6px;
            border-left: 4px solid #1d46ef;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #1d46ef;
            margin-bottom: 10px;
        }

        .summary-stats {
            display: table;
            width: 100%;
        }

        .summary-stat {
            display: table-cell;
            text-align: center;
            padding: 10px;
        }

        .summary-number {
            font-size: 18px;
            font-weight: bold;
            color: #1d46ef;
            display: block;
        }

        .summary-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
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
        <h1>📋 LISTE DES ÉQUIPEMENTS</h1>
        <p class="subtitle">{{ $client->name }} - {{ $equipment->count() }} équipements répertoriés</p>
    </div>

    <div class="pdf-container">
        <!-- Informations client -->
        <div class="client-info-section">
            <div class="client-info-title">INFORMATIONS CLIENT</div>
            <div class="client-details">
                <div class="client-detail-item">
                    <div class="detail-label">Client</div>
                    <div class="detail-value">{{ $client->name }}</div>
                </div>
                <div class="client-detail-item">
                    <div class="detail-label">Équipements</div>
                    <div class="detail-value">{{ $equipment->count() }}</div>
                </div>
                <div class="client-detail-item">
                    <div class="detail-label">Sociétés</div>
                    <div class="detail-value">{{ $client->companies->count() }}</div>
                </div>
                <div class="client-detail-item">
                    <div class="detail-label">Généré le</div>
                    <div class="detail-value">{{ $generated_at }}</div>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="equipment-summary">
            <div class="summary-title">RÉSUMÉ DES ÉQUIPEMENTS</div>
            <div class="summary-stats">
                <div class="summary-stat">
                    <span
                        class="summary-number">{{ $equipment->where('equipment.extension', '!=', null)->count() }}</span>
                    <span class="summary-label">Avec Extension</span>
                </div>
                <div class="summary-stat">
                    <span class="summary-number">{{ $equipment->where('equipment.extension', null)->count() }}</span>
                    <span class="summary-label">Sans Extension</span>
                </div>
                <div class="summary-stat">
                    <span class="summary-number">{{ $equipment->pluck('equipment.type')->unique()->count() }}</span>
                    <span class="summary-label">Types Différents</span>
                </div>
                <div class="summary-stat">
                    <span
                        class="summary-number">{{ $equipment->where('equipment.user_name', '!=', null)->count() }}</span>
                    <span class="summary-label">Assignés</span>
                </div>
            </div>
        </div>

        <!-- Tableau des équipements -->
        @if ($equipment->count() > 0)
            <table class="equipment-table">
                <thead>
                    <tr>
                        <th style="width: 12%;">Extension</th>
                        <th style="width: 18%;">Type</th>
                        <th style="width: 20%;">Utilisateur</th>
                        <th style="width: 15%;">Numéro</th>
                        <th style="width: 25%;">Société</th>
                        <th style="width: 10%;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipment->sortBy('equipment.extension') as $item)
                        <tr>
                            <td>
                                @if ($item['equipment']->extension)
                                    <span class="extension-badge">{{ $item['equipment']->extension }}</span>
                                @else
                                    <span class="no-extension">Non assignée</span>
                                @endif
                            </td>
                            <td>
                                <span class="type-badge">{{ $item['equipment']->type }}</span>
                            </td>
                            <td>
                                {{ $item['equipment']->user_name ?: 'Non assigné' }}
                            </td>
                            <td>
                                <span class="phone-badge">{{ $item['phone_number']->number }}</span>
                            </td>
                            <td>
                                <span class="company-badge">{{ $item['company']->name }}</span>
                                @if ($item['company']->type === 'subsidiary')
                                    <br><small style="color: #64748b;">(Filiale)</small>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if ($item['equipment']->extension && $item['equipment']->user_name)
                                    <span style="color: #10b981; font-weight: bold;">✓</span>
                                @else
                                    <span style="color: #f59e0b; font-weight: bold;">⚠</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 40px; color: #64748b; background: #f8faff; border-radius: 8px;">
                <h3 style="color: #1d46ef; margin-bottom: 10px;">Aucun équipement</h3>
                <p>Aucun équipement n'a été trouvé pour ce client.</p>
            </div>
        @endif
    </div>

    <div class="footer">
        <div class="left">© {{ date('Y') }} HR TELECOMS - Document Confidentiel</div>
        <div class="right">FreePBX Manager - Liste Équipements - Page {PAGE_NUM}</div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>
