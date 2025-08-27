@extends('layouts.app')

@section('title', 'Dashboard - FreePBX Manager Professional')
@section('breadcrumb', 'Dashboard Clients')
@section('page-title', 'Arbre de répartition')
@section('page-subtitle', 'Centralisez et gérez toutes vos infrastructures téléphoniques clients')

@section('content')
    <div id="app">
        <div id="alerts-container"></div>

        <div class="action-buttons" style="margin-bottom: 30px; display: flex; gap: 15px; flex-wrap: wrap;">
            <button class="btn btn-success" onclick="addClient()">
                <i class="fas fa-plus"></i> Nouveau Client
            </button>
            <button class="btn btn-primary" onclick="refreshClients()">
                <i class="fas fa-sync-alt"></i> Actualiser
            </button>
            <button class="btn btn-warning" onclick="generateGlobalReport()">
                <i class="fas fa-file-pdf"></i> Rapport Global PDF
            </button>
        </div>

        <div id="clients-container">
            <div class="loading" id="loading">
                <p><i class="fas fa-spinner fa-spin"></i> Chargement des clients...</p>
            </div>
            <div class="client-grid" id="clients-grid" style="display: none;">
                <!-- Les clients seront chargés ici dynamiquement -->
            </div>
        </div>

        <!-- Section de gestion de l'arbre (masquée par défaut) -->
        <div id="tree-section" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 id="current-client-name"
                    style="color: var(--dark-color); font-family: 'Poppins', sans-serif; font-size: 1.8em; font-weight: 600; margin: 0;">
                    <i class="fas fa-sitemap"></i> Infrastructure Client
                </h2>
                <div style="display: flex; gap: 12px; align-items: center;">
                    <span style="color: var(--medium-gray); font-size: 0.9em;">
                        <i class="fas fa-info-circle"></i> Dernière mise à jour: <span id="last-update">maintenant</span>
                    </span>
                </div>
            </div>

            <!-- Boutons d'action pour l'arbre -->
            <div class="action-buttons" style="margin-bottom: 25px; display: flex; gap: 12px; flex-wrap: wrap;">
                <button class="btn btn-danger" id="btn-generate-report"
                    style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                    <i class="fas fa-file-pdf"></i> Générer Rapport PDF
                </button>
                <button class="btn btn-danger" id="btn-generate-equipment"
                    style="background: linear-gradient(135deg, #f39c12, #d68910);">
                    <i class="fas fa-list-alt"></i> Liste Équipements PDF
                </button>
                <button class="btn btn-success" id="btn-add-main-company">
                    <i class="fas fa-building"></i> Ajouter Société Principale
                </button>
                <button class="btn btn-primary" onclick="hideTree()">
                    <i class="fas fa-arrow-left"></i> Retour aux clients
                </button>
            </div>

            <!-- Statistiques de l'arbre -->
            <div class="stats" id="tree-stats">
                <div class="stat-item">
                    <h4 id="treeCompaniesCount">0</h4>
                    <p><i class="fas fa-building"></i> Sociétés</p>
                </div>
                <div class="stat-item">
                    <h4 id="treePhonesCount">0</h4>
                    <p><i class="fas fa-phone"></i> Numéros</p>
                </div>
                <div class="stat-item">
                    <h4 id="treeEquipmentCount">0</h4>
                    <p><i class="fas fa-desktop"></i> Équipements</p>
                </div>
                <div class="stat-item">
                    <h4 id="treeExtensionsCount">0</h4>
                    <p><i class="fas fa-plug"></i> Extensions</p>
                </div>
            </div>

            <!-- Arbre hiérarchique intégré -->
            <div class="tree-container">
                <div class="tree" id="tree">
                    <div class="empty-state">
                        <i class="fas fa-sitemap"
                            style="font-size: 3em; color: var(--primary-color); margin-bottom: 20px;"></i>
                        <h3>Commencez votre infrastructure FreePBX</h3>
                        <p>Ajoutez votre première société avec son centrex pour démarrer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal amélioré -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Action</h3>
            </div>
            <div class="modal-body">
                <div id="modal-content">
                    <!-- Contenu généré dynamiquement -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
console.log('User connecté :', '{{ Auth::user()->name }}');
console.log('User ID :', '{{ Auth::id() }}');
</script>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute(
            'content');

        let clients = [];
        let currentClient = null;
        let treeData = [];
        let selectedEquipmentType = null;

        // Types d'équipements prédéfinis avec icônes FontAwesome
        const equipmentTypes = [{
                name: 'Téléphone fixe',
                icon: '📞',
                faIcon: 'fas fa-phone'
            },
            {
                name: 'Téléphone sans fil',
                icon: '📱',
                faIcon: 'fas fa-mobile-alt'
            },
            {
                name: 'Application mobile',
                icon: '📱',
                faIcon: 'fas fa-mobile'
            },
            {
                name: 'Application desktop',
                icon: '💻',
                faIcon: 'fas fa-desktop'
            },
            {
                name: 'Softphone',
                icon: '🎧',
                faIcon: 'fas fa-headset'
            },
            {
                name: 'Téléphone IP',
                icon: '🖥️',
                faIcon: 'fas fa-computer'
            }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            refreshClients();
        });

        function showAlert(message, type = 'success') {
            const alertsContainer = document.getElementById('alerts-container');
            const icons = {
                'success': 'fas fa-check-circle',
                'error': 'fas fa-exclamation-circle',
                'warning': 'fas fa-exclamation-triangle'
            };

            alertsContainer.innerHTML = `
        <div class="alert alert-${type}">
            <i class="${icons[type]}"></i>
            ${message}
        </div>
    `;

            setTimeout(() => {
                alertsContainer.innerHTML = '';
            }, 5000);
        }

        /**
         * Récupération des clients via API
         */
        async function refreshClients() {
            try {
                document.getElementById('loading').style.display = 'block';
                document.getElementById('clients-grid').style.display = 'none';

                const response = await axios.get('/api/v1/clients');
                clients = response.data.clients;

                document.getElementById('loading').style.display = 'none';
                renderClients();
            } catch (error) {
                console.error('Erreur lors du chargement des clients:', error);
                showAlert('Erreur lors du chargement des clients', 'error');
                document.getElementById('loading').style.display = 'none';
            }
        }

        /**
         * Affichage des clients avec design
         */
        function renderClients() {
            const grid = document.getElementById('clients-grid');

            if (clients.length === 0) {
                grid.innerHTML = `
            <div class="empty-state" style="grid-column: 1/-1;">
                <i class="fas fa-building" style="font-size: 4em; color: var(--primary-color); margin-bottom: 20px;"></i>
                <h3>Aucun client configuré</h3>
                <p>Commencez par ajouter votre premier client pour démarrer</p>
                <br>
                <button class="btn btn-success" onclick="addClient()">
                    <i class="fas fa-plus"></i> Créer le premier client
                </button>
            </div>
        `;
            } else {
                grid.innerHTML = clients.map(client => `
            <div class="client-card fade-in">
                <h3><i class="fas fa-building"></i> ${client.name}</h3>
                <div class="client-info">
                    ${client.email ? `<p><i class="fas fa-envelope"></i> ${client.email}</p>` : ''}
                    ${client.phone ? `<p><i class="fas fa-phone"></i> ${client.phone}</p>` : ''}
                    ${client.address ? `<p><i class="fas fa-map-marker-alt"></i> ${client.address.substring(0, 60)}${client.address.length > 60 ? '...' : ''}</p>` : ''}
                </div>
                
                <div class="client-stats">
                    <div class="stat-item">
                        <span class="stat-number">${client.companies_count}</span>
                        <span class="stat-label">Sociétés</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">${client.phone_numbers_count || 0}</span>
                        <span class="stat-label">Numéros</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">${client.equipment_count}</span>
                        <span class="stat-label">Équipements</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">${client.extensions_count}</span>
                        <span class="stat-label">Extensions</span>
                    </div>
                </div>
                
                <div class="client-actions" style="display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
                    <button class="btn btn-primary" onclick="viewClient(${client.id})">
                        <i class="fas fa-sitemap"></i> Voir l'arbre
                    </button>
                    <button class="btn btn-warning" onclick="editClient(${client.id})">
                        <i class="fas fa-edit"></i> Modifier
                    </button>
                    <button class="btn btn-danger" onclick="deleteClient(${client.id})">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </div>
            </div>
        `).join('');
            }

            grid.style.display = 'grid';
        }

        /**
         * Voir l'arbre d'un client
         */
        async function viewClient(clientId) {

            try {
                const response = await axios.get(`/api/v1/clients/${clientId}`);
                currentClient = response.data.client;

                document.getElementById('current-client-name').innerHTML =
                    `<i class="fas fa-sitemap"></i> Infrastructure de ${currentClient.name}`;

                // Mise à jour de l'heure
                document.getElementById('last-update').textContent = new Date().toLocaleString();

                // Configuration des boutons PDF
                document.getElementById('btn-generate-report').onclick = () =>
                    window.open(`/pdf/client-report/${clientId}`, '_blank');
                document.getElementById('btn-generate-equipment').onclick = () =>
                    window.open(`/pdf/equipment-list/${clientId}`, '_blank');

                // Bouton ajout société principale
                document.getElementById('btn-add-main-company').onclick = () =>
                    addMainCompanyTree(clientId);

                // Conversion des données API vers format arbre
                convertApiDataToTreeData(response.data.hierarchy);

                // Affichage de la section arbre
                document.getElementById('clients-container').style.display = 'none';
                document.getElementById('tree-section').style.display = 'block';
                console.log(response.data.hierarchy);
                // Rendu de l'arbre
                renderTree();
            } catch (error) {
                console.error('Erreur lors du chargement du client:', error);
                showAlert('Erreur lors du chargement du client', 'error');
            }

        }

        /**
         * Ajouter un client avec le nouveau design
         */
        async function addClient() {
            showModal(`
        <div class="form-group">
            <label><i class="fas fa-building"></i> Nom du client *</label>
            <input type="text" id="clientName" placeholder="ACME Corporation..." required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email</label>
            <input type="email" id="clientEmail" placeholder="contact@acme-corp.fr">
        </div>
        <div class="form-group">
            <label><i class="fas fa-phone"></i> Téléphone</label>
            <input type="text" id="clientPhone" placeholder="01 23 45 67 89">
        </div>
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt"></i> Adresse</label>
            <textarea id="clientAddress" rows="3" placeholder="123 Rue de la Paix, 75001 Paris"></textarea>
        </div>
        <div class="form-group">
            <label><i class="fas fa-info-circle"></i> Description</label>
            <textarea id="clientDescription" rows="2" placeholder="Description du client..."></textarea>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="saveClient()"><i class="fas fa-save"></i> Enregistrer</button>
            <button class="btn btn-secondary" onclick="closeModal()"><i class="fas fa-times"></i> Annuler</button>
        </div>
    `, 'Nouveau Client');
        }

        /**
         * Sauvegarder un client
         */
        async function saveClient() {
            const name = document.getElementById('clientName').value.trim();
            const email = document.getElementById('clientEmail').value.trim();
            const phone = document.getElementById('clientPhone').value.trim();
            const address = document.getElementById('clientAddress').value.trim();
            const description = document.getElementById('clientDescription').value.trim();

            if (!name) {
                showAlert('Le nom du client est obligatoire', 'error');
                return;
            }

            try {
                await axios.post('/api/v1/clients', {
                    name,
                    email,
                    phone,
                    address,
                    description
                });

                closeModal();
                showAlert('Client créé avec succès !');
                refreshClients();
            } catch (error) {
                console.error('Erreur lors de la création du client:', error);
                if (error.response && error.response.data.errors) {
                    const errors = Object.values(error.response.data.errors).flat();
                    showAlert(errors.join('<br>'), 'error');
                } else {
                    showAlert('Erreur lors de la création du client', 'error');
                }
            }
        }

        /**
         * Modifier un client
         */
        async function editClient(clientId) {
            const client = clients.find(c => c.id === clientId);
            if (!client) return;

            showModal(`
        <div class="form-group">
            <label><i class="fas fa-building"></i> Nom du client *</label>
            <input type="text" id="clientName" value="${client.name}" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email</label>
            <input type="email" id="clientEmail" value="${client.email || ''}">
        </div>
        <div class="form-group">
            <label><i class="fas fa-phone"></i> Téléphone</label>
            <input type="text" id="clientPhone" value="${client.phone || ''}">
        </div>
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt"></i> Adresse</label>
            <textarea id="clientAddress" rows="3">${client.address || ''}</textarea>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="updateClient(${clientId})"><i class="fas fa-save"></i> Mettre à jour</button>
            <button class="btn btn-secondary" onclick="closeModal()"><i class="fas fa-times"></i> Annuler</button>
        </div>
    `, 'Modifier Client');
        }

        /**
         * Mettre à jour un client
         */
        async function updateClient(clientId) {
            const name = document.getElementById('clientName').value.trim();
            const email = document.getElementById('clientEmail').value.trim();
            const phone = document.getElementById('clientPhone').value.trim();
            const address = document.getElementById('clientAddress').value.trim();

            if (!name) {
                showAlert('Le nom du client est obligatoire', 'error');
                return;
            }

            try {
                await axios.put(`/api/v1/clients/${clientId}`, {
                    name,
                    email,
                    phone,
                    address
                });

                closeModal();
                showAlert('Client mis à jour avec succès !');
                refreshClients();
            } catch (error) {
                console.error('Erreur lors de la mise à jour:', error);
                showAlert('Erreur lors de la mise à jour du client', 'error');
            }
        }

        /**
         * Supprimer un client - FONCTION MANQUANTE
         */
        async function deleteClient(clientId) {
            const client = clients.find(c => c.id === clientId);
            if (!client) return;

            if (!confirm(
                    `Êtes-vous sûr de vouloir supprimer "${client.name}" et toutes ses données ?\n\nCette action est irréversible !`
                )) {
                return;
            }

            try {
                await axios.delete(`/api/v1/clients/${clientId}`);
                showAlert('Client supprimé avec succès !');
                refreshClients();
            } catch (error) {
                console.error('Erreur lors de la suppression:', error);
                showAlert('Erreur lors de la suppression du client', 'error');
            }
        }

        /**
         * Générer le rapport global
         */
        function generateGlobalReport() {
            window.open('/pdf/global-report', '_blank');
        }

        /**
         * Fonction pour montrer un modal professionnel
         */
        function showModal(content, title = 'Action') {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-content').innerHTML = content;
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            selectedEquipmentType = null;
        }

        /**
         * Retour à la liste des clients
         */
        function hideTree() {
            document.getElementById('clients-container').style.display = 'block';
            document.getElementById('tree-section').style.display = 'none';
            currentClient = null;
            treeData = [];
        }

        // =========================================================================
        // FONCTIONS POUR L'ARBRE HIÉRARCHIQUE
        // =========================================================================

        /**
         * Convertit les données de l'API Laravel vers le format attendu par l'arbre
         */
        function convertApiDataToTreeData(hierarchy) {
            treeData = hierarchy.map(company => convertCompanyToTreeNode(company));
        }

        function convertCompanyToTreeNode(company) {
            const children = [];

            // Ajouter les filiales
            if (company.subsidiaries) {
                company.subsidiaries.forEach(subsidiary => {
                    children.push(convertCompanyToTreeNode(subsidiary));
                });
            }

            // Ajouter les numéros de téléphone
            if (company.phone_numbers) {
                company.phone_numbers.forEach(phone => {
                    const phoneNode = {
                        id: `phone_${phone.id}`,
                        name: phone.number,
                        type: 'phone-number',
                        children: [],
                        expanded: true,
                        apiId: phone.id
                    };

                    // Ajouter les équipements
                    if (phone.equipment) {
                        phone.equipment.forEach(equipment => {
                            phoneNode.children.push({
                                id: `equipment_${equipment.id}`,
                                name: equipment.name,
                                type: 'equipment',
                                equipmentType: equipment.type,
                                extension: equipment.extension,
                                userName: equipment.user_name,
                                children: [],
                                expanded: true,
                                apiId: equipment.id
                            });
                        });
                    }

                    children.push(phoneNode);
                });
            }

            return {
                id: `company_${company.id}`,
                name: company.name,
                type: company.type === 'main' ? 'company-main' : 'company-sub',
                ip: company.centrex_ip,
                children: children,
                expanded: true,
                apiId: company.id
            };
        }

        /**
         * Mise à jour des statistiques
         */
        function updateTreeStats() {
            let companies = 0,
                phones = 0,
                equipment = 0,
                extensions = 0;

            function countInNode(node) {
                if (node.type === 'company-sub' || node.type === 'company-main') companies++;
                if (node.type === 'phone-number') phones++;
                if (node.type === 'equipment') {
                    equipment++;
                    if (node.extension) extensions++;
                }

                if (node.children) {
                    node.children.forEach(countInNode);
                }
            }

            treeData.forEach(countInNode);

            document.getElementById('treeCompaniesCount').textContent = companies;
            document.getElementById('treePhonesCount').textContent = phones;
            document.getElementById('treeEquipmentCount').textContent = equipment;
            document.getElementById('treeExtensionsCount').textContent = extensions;
        }

        /**
         * Rendu de l'arbre
         */
        function renderTree() {
            const treeElement = document.getElementById('tree');

            if (treeData.length === 0) {
                treeElement.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-sitemap" style="font-size: 3em; color: var(--primary-color); margin-bottom: 20px;"></i>
                <h3>Commencez votre infrastructure FreePBX</h3>
                <p>Ajoutez votre première société avec son centrex pour démarrer</p>
            </div>
        `;
                return;
            }

            treeElement.innerHTML = treeData.map(renderNode).join('');
            updateTreeStats();
        }

        /**
         * Rendu d'un nœud
         */
        function renderNode(node) {
            const icons = {
                'company-main': '🏢',
                'company-sub': '🏬',
                'phone-number': '📞',
                'equipment': getEquipmentIcon(node.equipmentType || node.name)
            };

            const typeLabels = {
                'company-main': 'Siège',
                'company-sub': 'Filiale',
                'phone-number': 'Numéro',
                'equipment': 'Équipement'
            };

            const hasChildren = node.children && node.children.length > 0;
            const isExpanded = node.expanded !== false;

            let details = '';
            if (node.ip) {
                details += `<span class="detail-item ip-address">IP: ${node.ip}</span>`;
            }
            if (node.extension) {
                details += `<span class="detail-item extension">Ext: ${node.extension}</span>`;
            }
            if (node.userName) {
                details += `<span class="detail-item user-name">${node.userName}</span>`;
            }

            return `
    <div class="tree-node ${node.type}" id="node-${node.id}">
        <div class="node-header">
            <div class="node-main-content">
                ${hasChildren ? 
                    `<button class="toggle-btn ${!isExpanded ? 'collapsed' : ''}" onclick="toggleNode('${node.id}')">▼</button>` : 
                    '<span style="width: 25px;"></span>'
                }
                <span class="node-icon">${icons[node.type] || '📄'}</span>
                <div class="node-content">
                    <div class="node-title">
                        ${node.name}
                        <span class="node-type-badge">${typeLabels[node.type]}</span>
                    </div>
                    ${details ? `<div class="node-details">${details}</div>` : ''}
                </div>
            </div>
            <div class="node-actions">
                ${getActionButtons(node)}
            </div>
        </div>
        ${hasChildren ? `
                    <div class="node-children ${!isExpanded ? 'hidden' : ''}">
                        ${node.children.map(renderNode).join('')}
                    </div>
                ` : ''}
    </div>
`;
        }

        function getEquipmentIcon(name) {
            const equipment = equipmentTypes.find(eq => eq.name === name);
            return equipment ? equipment.icon : '🔧';
        }

        /**
         * Boutons d'action selon le type de nœud
         */
        function getActionButtons(node) {
            let buttons =
                `<button class="btn-tree btn-edit" onclick="editTreeNode('${node.id}')" title="Modifier">✏️</button>`;

            switch (node.type) {
                case 'company-main':
                    buttons +=
                        `<button class="btn-tree btn-add" onclick="addSubCompanyTree('${node.id}')" title="Ajouter une filiale">+ Filiale</button>`;
                    buttons +=
                        `<button class="btn-tree btn-add" onclick="addPhoneNumberTree('${node.id}')" title="Ajouter un numéro">+ Numéro</button>`;
                    break;
                case 'company-sub':
                    buttons +=
                        `<button class="btn-tree btn-add" onclick="addPhoneNumberTree('${node.id}')" title="Ajouter un numéro">+ Numéro</button>`;
                    break;
                case 'phone-number':
                    buttons +=
                        `<button class="btn-tree btn-add" onclick="addEquipmentTree('${node.id}')" title="Ajouter un équipement">+ Équipement</button>`;
                    break;
            }

            buttons +=
                `<button class="btn-tree btn-delete" onclick="deleteTreeNode('${node.id}')" title="Supprimer">🗑️</button>`;
            return buttons;
        }

        /**
         * Fonction utilitaire pour trouver un nœud
         */
        function findNodeById(id, nodes = treeData) {
            for (let node of nodes) {
                if (node.id === id) return node;
                if (node.children) {
                    const found = findNodeById(id, node.children);
                    if (found) return found;
                }
            }
            return null;
        }

        /**
         * Basculer l'expansion d'un nœud
         */
        function toggleNode(id) {
            const node = findNodeById(id);
            if (node) {
                node.expanded = !node.expanded;
                renderTree();
            }
        }

        /**
         * Ajouter une société principale depuis l'arbre
         */
        function addMainCompanyTree(clientId) {
            showModal(`
        <div class="form-group">
            <label><i class="fas fa-building"></i> Nom de la société *</label>
            <input type="text" id="companyName" placeholder="ACME Siège..." required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-network-wired"></i> Adresse IP du centrex</label>
            <input type="text" id="companyCentrexIP" placeholder="192.168.1.100">
            <div class="input-helper">Format: XXX.XXX.XXX.XXX</div>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="saveMainCompanyTree(${clientId})"><i class="fas fa-save"></i> Enregistrer</button>
            <button class="btn btn-secondary" onclick="closeModal()"><i class="fas fa-times"></i> Annuler</button>
        </div>
    `, 'Nouvelle Société Principale');
        }

        /**
         * Sauvegarder une société principale et rafraîchir l'arbre
         */
        async function saveMainCompanyTree(clientId) {
            const name = document.getElementById('companyName').value.trim();
            const centrex_ip = document.getElementById('companyCentrexIP').value.trim();

            if (!name) {
                showAlert('Le nom de la société est obligatoire', 'error');
                return;
            }

            try {
                await axios.post('/api/v1/companies', {
                    client_id: clientId,
                    name: name,
                    centrex_ip: centrex_ip,
                    type: 'main'
                });

                closeModal();
                showAlert('Société créée avec succès !');
                viewClient(clientId); // Recharger l'arbre
            } catch (error) {
                console.error('Erreur lors de la création de la société:', error);
                showAlert('Erreur lors de la création de la société', 'error');
            }
        }

        /**
         * Ajouter une filiale
         */
        function addSubCompanyTree(parentNodeId) {
            showModal(`
        <div class="form-group">
            <label><i class="fas fa-building"></i> Nom de la filiale *</label>
            <input type="text" id="companyName" placeholder="ACME Paris..." required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-network-wired"></i> Adresse IP du centrex</label>
            <input type="text" id="companyCentrexIP" placeholder="192.168.1.101">
            <div class="input-helper">Format: XXX.XXX.XXX.XXX</div>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="saveSubCompanyTree('${parentNodeId}')">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <button class="btn btn-secondary" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    `, 'Nouvelle Filiale');
        }

        async function saveSubCompanyTree(parentNodeId) {
            const parentNode = findNodeById(parentNodeId);
            const name = document.getElementById('companyName').value.trim();
            const centrex_ip = document.getElementById('companyCentrexIP').value.trim();

            if (!name) {
                showAlert('Le nom de la société est obligatoire', 'error');
                return;
            }

            try {
                await axios.post('/api/v1/companies', {
                    client_id: currentClient.id,
                    name: name,
                    centrex_ip: centrex_ip,
                    type: 'subsidiary',
                    parent_id: parentNode.apiId
                });

                closeModal();
                showAlert('Filiale créée avec succès !');
                viewClient(currentClient.id); // Recharger l'arbre
            } catch (error) {
                console.error('Erreur lors de la création de la filiale:', error);
                showAlert('Erreur lors de la création de la filiale', 'error');
            }
        }

        /**
         * Ajouter un numéro de téléphone
         */
        function addPhoneNumberTree(parentNodeId) {
            showModal(`
        <div class="form-group">
            <label><i class="fas fa-phone"></i> Numéro de téléphone *</label>
            <input type="text" id="phoneNumber" placeholder="0123456789" required>
            <div class="input-helper">Format: 10 chiffres sans espaces</div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-tags"></i> Type de numéro</label>
            <select id="phoneType">
                <option value="landline">Téléphone fixe</option>
                <option value="mobile">Téléphone mobile</option>
                <option value="toll-free">Numéro vert</option>
                <option value="premium">Numéro surtaxé</option>
            </select>
        </div>
        <div class="form-group">
            <label><i class="fas fa-info-circle"></i> Description</label>
            <textarea id="phoneDescription" rows="2" placeholder="Description optionnelle du numéro..."></textarea>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="savePhoneNumberTree('${parentNodeId}')">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <button class="btn btn-secondary" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    `, 'Nouveau Numéro de Téléphone');
        }

        async function savePhoneNumberTree(parentNodeId) {
            const parentNode = findNodeById(parentNodeId);
            const number = document.getElementById('phoneNumber').value.trim();
            const type = document.getElementById('phoneType').value;
            const description = document.getElementById('phoneDescription').value.trim();

            if (!number) {
                showAlert('Le numéro de téléphone est obligatoire', 'error');
                return;
            }

            try {
                await axios.post('/api/v1/phone-numbers', {
                    company_id: parentNode.apiId,
                    number: number,
                    type: type,
                    description: description
                });

                closeModal();
                showAlert('Numéro créé avec succès !');
                viewClient(currentClient.id); // Recharger l'arbre
            } catch (error) {
                console.error('Erreur lors de la création du numéro:', error);
                showAlert('Erreur lors de la création du numéro', 'error');
            }
        }

        /**
         * Ajouter un équipement (fonction complète)
         */
        function addEquipmentTree(parentNodeId) {
            selectedEquipmentType = null;

            const modalContent = `
        <div class="form-group">
            <label><i class="fas fa-desktop"></i> Type d'équipement</label>
            <div class="equipment-types">
                ${equipmentTypes.map(eq => `
                                                        <div class="equipment-type-btn" onclick="selectEquipmentType('${eq.name}')">
                                                            <i class="${eq.faIcon}"></i> ${eq.name}
                                                        </div>
                                                    `).join('')}
            </div>
            <input type="text" id="customEquipment" placeholder="Ou équipement personnalisé...">
        </div>
        <div class="form-group">
            <label><i class="fas fa-plug"></i> Numéro d'extension</label>
            <input type="text" id="extension" placeholder="1001">
            <div class="input-helper">Extension FreePBX (ex: 1001, 2000, etc.)</div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nom de l'utilisateur</label>
            <input type="text" id="userName" placeholder="Jean Dupont">
            <div class="input-helper">Nom de la personne utilisant cet équipement</div>
        </div>
        <div id="equipmentPreview" class="extension-preview" style="display: none;">
            <strong><i class="fas fa-eye"></i> Aperçu:</strong> <span id="previewText"></span>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="saveEquipmentTree('${parentNodeId}')">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <button class="btn btn-secondary" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    `;

            showModal(modalContent, 'Nouvel Équipement');

            // Attendre que le DOM soit complètement rendu avant d'ajouter les listeners
            setTimeout(() => {
                setupEquipmentListeners();
            }, 200); // Augmenté de 100ms à 200ms pour plus de sécurité
        }

        function setupEquipmentListeners() {
            const elementIds = ['extension', 'userName', 'customEquipment'];

            elementIds.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateEquipmentPreview);
                } else {
                    console.warn(`Élément ${id} non trouvé lors de la configuration des listeners`);
                }
            });

            // Mise à jour initiale de l'aperçu
            updateEquipmentPreview();
        }

        function selectEquipmentType(type) {
            selectedEquipmentType = type;

            // Vider le champ personnalisé
            const customEquipmentEl = document.getElementById('customEquipment');
            if (customEquipmentEl) {
                customEquipmentEl.value = '';
            }

            // Mise à jour visuelle
            document.querySelectorAll('.equipment-type-btn').forEach(btn => {
                btn.classList.remove('selected');
            });

            // Trouver le bouton cliqué et l'activer
            const clickedBtn = event.target.closest('.equipment-type-btn');
            if (clickedBtn) {
                clickedBtn.classList.add('selected');
            }

            updateEquipmentPreview();
        }


        function updateEquipmentPreview() {
            const extensionEl = document.getElementById('extension');
            const userNameEl = document.getElementById('userName');
            const customEquipmentEl = document.getElementById('customEquipment');
            const previewEl = document.getElementById('equipmentPreview');
            const previewTextEl = document.getElementById('previewText');

            // Vérifier que les éléments existent
            if (!extensionEl || !userNameEl || !customEquipmentEl || !previewEl || !previewTextEl) {
                return; // Sortir silencieusement si les éléments n'existent pas encore
            }

            const extension = extensionEl.value;
            const userName = userNameEl.value;
            const customEquipment = customEquipmentEl.value;

            if (extension || userName || selectedEquipmentType || customEquipment) {
                const equipmentName = selectedEquipmentType || customEquipment || 'Équipement';
                const preview =
                    `${equipmentName}${extension ? ` - Ext: ${extension}` : ''}${userName ? ` - ${userName}` : ''}`;

                previewTextEl.textContent = preview;
                previewEl.style.display = 'block';
            } else {
                previewEl.style.display = 'none';
            }
        }

        async function saveEquipmentTree(parentNodeId) {
            const parentNode = findNodeById(parentNodeId);

            // Vérification de sécurité pour les éléments DOM
            const extensionEl = document.getElementById('extension');
            const userNameEl = document.getElementById('userName');
            const customEquipmentEl = document.getElementById('customEquipment');
            const macAddressEl = document.getElementById('macAddress');

            // Vérifier que tous les éléments existent
            if (!extensionEl || !userNameEl || !customEquipmentEl) {
                console.error('Erreur: Éléments du formulaire non trouvés');
                showAlert('Erreur lors de la lecture du formulaire. Veuillez réessayer.', 'error');
                return;
            }

            // Récupération sécurisée des valeurs
            const extension = extensionEl.value.trim();
            const userName = userNameEl.value.trim();
            const customEquipment = customEquipmentEl.value.trim();
            const macAddress = macAddressEl ? macAddressEl.value.trim() : '';

            const equipmentType = selectedEquipmentType || customEquipment;
            if (!equipmentType) {
                showAlert('Le type d\'équipement est obligatoire', 'error');
                return;
            }

            try {
                await axios.post('/api/v1/equipment', {
                    phone_number_id: parentNode.apiId,
                    type: equipmentType,
                    extension: extension,
                    user_name: userName,
                    mac_address: macAddress
                });

                closeModal();
                showAlert('Équipement créé avec succès !');
                viewClient(currentClient.id); // Recharger l'arbre
            } catch (error) {
                console.error('Erreur lors de la création de l\'équipement:', error);
                showAlert('Erreur lors de la création de l\'équipement', 'error');
            }
        }


        /**
         * Éditer un nœud de l'arbre
         */
        function editTreeNode(nodeId) {
            const node = findNodeById(nodeId);
            if (!node) return;

            switch (node.type) {
                case 'company-main':
                case 'company-sub':
                    editCompanyTree(node);
                    break;
                case 'phone-number':
                    editPhoneTree(node);
                    break;
                case 'equipment':
                    editEquipmentTree(node);
                    break;
            }
        }

        function editCompanyTree(node) {
            showModal(`
        <div class="form-group">
            <label><i class="fas fa-building"></i> Nom de la société *</label>
            <input type="text" id="companyName" value="${node.name}" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-network-wired"></i> Adresse IP du centrex</label>
            <input type="text" id="companyCentrexIP" value="${node.ip || ''}" placeholder="192.168.1.100">
            <div class="input-helper">Format: XXX.XXX.XXX.XXX</div>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="updateCompanyTree('${node.id}')">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <button class="btn btn-secondary" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    `, `Modifier ${node.type === 'company-main' ? 'Société Principale' : 'Filiale'}`);
        }

        async function updateCompanyTree(nodeId) {
            const node = findNodeById(nodeId);
            const name = document.getElementById('companyName').value.trim();
            const centrex_ip = document.getElementById('companyCentrexIP').value.trim();

            if (!name) {
                showAlert('Le nom de la société est obligatoire', 'error');
                return;
            }

            try {
                await axios.put(`/api/v1/companies/${node.apiId}`, {
                    name: name,
                    centrex_ip: centrex_ip
                });

                closeModal();
                showAlert('Société mise à jour avec succès !');
                viewClient(currentClient.id);
            } catch (error) {
                console.error('Erreur lors de la mise à jour:', error);
                showAlert('Erreur lors de la mise à jour', 'error');
            }
        }

        function editPhoneTree(node) {
            showModal(`
        <div class="form-group">
            <label><i class="fas fa-phone"></i> Numéro de téléphone *</label>
            <input type="text" id="phoneNumber" value="${node.name}" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-tags"></i> Type de numéro</label>
            <select id="phoneType">
                <option value="landline">Téléphone fixe</option>
                <option value="mobile">Téléphone mobile</option>
                <option value="toll-free">Numéro vert</option>
                <option value="premium">Numéro surtaxé</option>
            </select>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="updatePhoneTree('${node.id}')">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <button class="btn btn-secondary" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    `, 'Modifier Numéro de Téléphone');
        }

        async function updatePhoneTree(nodeId) {
            const node = findNodeById(nodeId);
            const number = document.getElementById('phoneNumber').value.trim();
            const type = document.getElementById('phoneType').value;

            if (!number) {
                showAlert('Le numéro de téléphone est obligatoire', 'error');
                return;
            }

            try {
                await axios.put(`/api/v1/phone-numbers/${node.apiId}`, {
                    number: number,
                    type: type
                });

                closeModal();
                showAlert('Numéro mis à jour avec succès !');
                viewClient(currentClient.id);
            } catch (error) {
                console.error('Erreur lors de la mise à jour:', error);
                showAlert('Erreur lors de la mise à jour', 'error');
            }
        }

        function editEquipmentTree(node) {
            selectedEquipmentType = node.equipmentType;

            const modalContent = `
        <div class="form-group">
            <label><i class="fas fa-desktop"></i> Type d'équipement</label>
            <div class="equipment-types">
                ${equipmentTypes.map(eq => `
                                        <div class="equipment-type-btn ${node.equipmentType === eq.name ? 'selected' : ''}" 
                                             onclick="selectEquipmentType('${eq.name}')">
                                            <i class="${eq.faIcon}"></i> ${eq.name}
                                        </div>
                                    `).join('')}
            </div>
            <input type="text" id="customEquipment" placeholder="Ou équipement personnalisé..." 
                   value="${!equipmentTypes.find(eq => eq.name === node.equipmentType) ? node.equipmentType : ''}">
        </div>
        <div class="form-group">
            <label><i class="fas fa-plug"></i> Numéro d'extension</label>
            <input type="text" id="extension" value="${node.extension || ''}" placeholder="1001">
        </div>
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nom de l'utilisateur</label>
            <input type="text" id="userName" value="${node.userName || ''}" placeholder="Jean Dupont">
        </div>
        <div id="equipmentPreview" class="extension-preview" style="display: none;">
            <strong><i class="fas fa-eye"></i> Aperçu:</strong> <span id="previewText"></span>
        </div>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="updateEquipmentTree('${node.id}')">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <button class="btn btn-secondary" onclick="closeModal()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    `;

            showModal(modalContent, 'Modifier Équipement');

            // Attendre le rendu puis configurer
            setTimeout(() => {
                setupEquipmentListeners();
            }, 200);
        }

        async function updateEquipmentTree(nodeId) {
            const node = findNodeById(nodeId);

            // Vérifications de sécurité
            const extensionEl = document.getElementById('extension');
            const userNameEl = document.getElementById('userName');
            const customEquipmentEl = document.getElementById('customEquipment');

            if (!extensionEl || !userNameEl || !customEquipmentEl) {
                showAlert('Erreur lors de la lecture du formulaire', 'error');
                return;
            }

            const extension = extensionEl.value.trim();
            const userName = userNameEl.value.trim();
            const customEquipment = customEquipmentEl.value.trim();

            const equipmentType = selectedEquipmentType || customEquipment;
            if (!equipmentType) {
                showAlert('Le type d\'équipement est obligatoire', 'error');
                return;
            }

            try {
                await axios.put(`/api/v1/equipment/${node.apiId}`, {
                    type: equipmentType,
                    extension: extension,
                    user_name: userName
                });

                closeModal();
                showAlert('Équipement mis à jour avec succès !');
                viewClient(currentClient.id);
            } catch (error) {
                console.error('Erreur lors de la mise à jour:', error);
                showAlert('Erreur lors de la mise à jour', 'error');
            }
        }

        /**
         * Supprimer un nœud de l'arbre
         */
        async function deleteTreeNode(nodeId) {
            const node = findNodeById(nodeId);
            if (!node) return;

            const typeNames = {
                'company-main': 'société principale',
                'company-sub': 'filiale',
                'phone-number': 'numéro de téléphone',
                'equipment': 'équipement'
            };

            const typeName = typeNames[node.type] || 'élément';

            if (!confirm(
                    `Êtes-vous sûr de vouloir supprimer cette ${typeName} "${node.name}" et tous ses sous-éléments ?\n\nCette action est irréversible !`
                )) {
                return;
            }

            try {
                let endpoint = '';
                switch (node.type) {
                    case 'company-main':
                    case 'company-sub':
                        endpoint = `/api/v1/companies/${node.apiId}`;
                        break;
                    case 'phone-number':
                        endpoint = `/api/v1/phone-numbers/${node.apiId}`;
                        break;
                    case 'equipment':
                        endpoint = `/api/v1/equipment/${node.apiId}`;
                        break;
                }

                await axios.delete(endpoint);
                showAlert(`${typeName.charAt(0).toUpperCase() + typeName.slice(1)} supprimé(e) avec succès !`);
                viewClient(currentClient.id); // Recharger l'arbre
            } catch (error) {
                console.error('Erreur lors de la suppression:', error);
                showAlert('Erreur lors de la suppression', 'error');
            }
        }

        // Fermer le modal en cliquant à côté
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Gestion des touches clavier
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
    <script>
        /**
         * Fonction de débogage pour vérifier l'état du DOM
         */
        function debugModalElements() {
            console.log('=== DEBUG MODAL ===');
            console.log('Modal visible:', document.getElementById('modal').style.display);
            console.log('Extension element:', document.getElementById('extension'));
            console.log('UserName element:', document.getElementById('userName'));
            console.log('CustomEquipment element:', document.getElementById('customEquipment'));
            console.log('MacAddress element:', document.getElementById('macAddress'));
            console.log('SelectedEquipmentType:', selectedEquipmentType);
            console.log('==================');
        }

        // Vous pouvez appeler debugModalElements() dans la console pour diagnostiquer
    </script>
@endsection
