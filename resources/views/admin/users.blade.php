@extends('layouts.app')

@section('title', 'Administration - Gestion des Utilisateurs')
@section('breadcrumb', 'Administration > Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')
@section('page-subtitle', 'Administrez les comptes utilisateurs et leurs permissions')

@section('content')
    <div id="admin-users-container">
        <!-- Messages d'alerte -->
        <div id="admin-alerts-container"></div>

        @if (Auth::user()->role === 'admin')
            <div style="margin-bottom: 20px; text-align: right;">
                <a href="{{ route('dashboard') }}" class="btn btn-primary" style="background: #e74c3c;">
                    <i class="fas fa-arrow-left"></i> Retour au Dashboard
                </a>
            </div>
        @endif

        <!-- Statistiques rapides -->
        <div class="admin-stats-overview">
            <div class="admin-stat-card">
                <div class="admin-stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $users->total() }}</h3>
                    <p>Total Utilisateurs</p>
                </div>
            </div>
            <div class="admin-stat-card admin-stat-admin">
                <div class="admin-stat-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $stats['total_admins'] }}</h3>
                    <p>Administrateurs</p>
                </div>
            </div>
            <div class="admin-stat-card admin-stat-users">
                <div class="admin-stat-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $users->total() - $stats['total_admins'] }}</h3>
                    <p>Utilisateurs Standard</p>
                </div>
            </div>
            <div class="admin-stat-card admin-stat-recent">
                <div class="admin-stat-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $stats['recent_users']->count() }}</h3>
                    <p>Nouveaux (7j)</p>
                </div>
            </div>
        </div>

        <!-- Barre d'outils -->
        <div class="admin-toolbar">
            <div class="admin-toolbar-section">
                <div class="admin-search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="admin-search-users" placeholder="Rechercher un utilisateur..."
                        value="{{ request('search') }}">
                </div>
                <div class="admin-filter-container">
                    <select id="admin-filter-role">
                        <option value="">Tous les rôles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateurs</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Utilisateurs</option>
                    </select>
                </div>
            </div>
            <div class="admin-toolbar-actions">
                <button class="admin-btn admin-btn-success" onclick="exportUsers()">
                    <i class="fas fa-download"></i> Exporter
                </button>
                <button class="admin-btn admin-btn-warning" onclick="refreshUsers()">
                    <i class="fas fa-sync-alt"></i> Actualiser
                </button>
            </div>
        </div>

        <!-- Actions en lot -->
        <div class="admin-bulk-actions" id="admin-bulk-actions" style="display: none;">
            <div class="admin-bulk-info">
                <span id="admin-selected-count">0</span> utilisateur(s) sélectionné(s)
            </div>
            <div class="admin-bulk-buttons">
                <button class="admin-btn admin-btn-primary" onclick="bulkChangeRole()">
                    <i class="fas fa-users-cog"></i> Changer le rôle
                </button>
                <button class="admin-btn admin-btn-danger" onclick="bulkDeleteUsers()">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="clearSelection()">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="admin-users-table-container">
            <table class="admin-users-table">
                <thead>
                    <tr>
                        <th class="admin-select-column">
                            <input type="checkbox" id="admin-select-all" onchange="toggleSelectAll()">
                        </th>
                        <th class="admin-sortable" onclick="sortTable('name')">
                            <i class="fas fa-user"></i> Nom
                            <i class="fas fa-sort admin-sort-icon"></i>
                        </th>
                        <th class="admin-sortable" onclick="sortTable('email')">
                            <i class="fas fa-envelope"></i> Email
                            <i class="fas fa-sort admin-sort-icon"></i>
                        </th>
                        <th class="admin-sortable" onclick="sortTable('role')">
                            <i class="fas fa-shield-alt"></i> Rôle
                            <i class="fas fa-sort admin-sort-icon"></i>
                        </th>
                        <th>
                            <i class="fas fa-building"></i> Clients
                        </th>
                        <th class="admin-sortable" onclick="sortTable('created_at')">
                            <i class="fas fa-calendar"></i> Inscription
                            <i class="fas fa-sort admin-sort-icon"></i>
                        </th>
                        <th>
                            <i class="fas fa-clock"></i> Dernière connexion
                        </th>
                        <th class="admin-actions-column">
                            <i class="fas fa-cogs"></i> Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr data-user-id="{{ $user->id }}"
                            class="admin-user-row {{ $user->id === auth()->id() ? 'admin-current-user' : '' }}">
                            <td class="admin-select-column">
                                @if ($user->id !== auth()->id())
                                    <input type="checkbox" class="admin-user-checkbox" value="{{ $user->id }}"
                                        onchange="updateSelection()">
                                @endif
                            </td>
                            <td class="admin-user-info">
                                <div class="admin-user-avatar-mini">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="admin-user-details">
                                    <strong>{{ $user->name }}</strong>
                                    @if ($user->id === auth()->id())
                                        <small class="admin-current-user-badge">Vous</small>
                                    @endif
                                </div>
                            </td>
                            <td class="admin-user-email">
                                {{ $user->email }}
                                @if ($user->email_verified_at)
                                    <i class="fas fa-check-circle admin-verified" title="Email vérifié"></i>
                                @else
                                    <i class="fas fa-exclamation-triangle admin-unverified" title="Email non vérifié"></i>
                                @endif
                            </td>
                            <td class="admin-user-role">
                                <div class="admin-role-container">
                                    <span class="admin-role-badge admin-role-{{ $user->role }}">
                                        <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }}"></i>
                                        {{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                                    </span>
                                    @if ($user->id !== auth()->id())
                                        <button class="admin-btn-mini admin-btn-edit-role"
                                            onclick="event.stopPropagation(); editRole({{ $user->id }}, '{{ $user->role }}')"
                                            title="Modifier le rôle">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td class="admin-user-clients">
                                <span class="admin-clients-count">
                                    <i class="fas fa-building"></i> 0
                                </span>
                            </td>
                            <td class="admin-user-created">
                                {{ $user->created_at->format('d/m/Y') }}
                                <small>{{ $user->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="admin-user-last-login">
                                @if (isset($user->last_login_at))
                                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                                    <small>{{ $user->last_login_at->diffForHumans() }}</small>
                                @else
                                    <span class="admin-text-muted">Jamais connecté</span>
                                @endif
                            </td>
                            <td class="admin-actions-column">
                                <div class="admin-action-buttons">
                                    <button class="admin-btn-action admin-btn-edit"
                                        onclick="event.stopPropagation(); editUser({{ $user->id }})"
                                        title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if ($user->id !== auth()->id() && !($user->role === 'admin' && $stats['total_admins'] === 1))
                                        <button class="admin-btn-action admin-btn-delete"
                                            onclick="event.stopPropagation(); deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                            title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-no-users">
                                <div class="admin-empty-state">
                                    <i class="fas fa-users"></i>
                                    <h3>Aucun utilisateur trouvé</h3>
                                    <p>Aucun utilisateur ne correspond à vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="admin-pagination-container">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

    <!-- Modal pour éditer le rôle -->
    <div id="admin-role-modal" class="admin-modal">
        <div class="admin-modal-content">
            <div class="admin-modal-header">
                <h3 id="admin-role-modal-title">Modifier le rôle</h3>
            </div>
            <div class="admin-modal-body">
                <div id="admin-role-modal-content">
                    <!-- Contenu généré dynamiquement -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour éditer l'utilisateur -->
    <div id="admin-edit-modal" class="admin-modal">
        <div class="admin-modal-content">
            <div class="admin-modal-header">
                <h3 id="admin-edit-modal-title">Modifier l'utilisateur</h3>
            </div>
            <div class="admin-modal-body">
                <div id="admin-edit-modal-content">
                    <!-- Contenu généré dynamiquement -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let selectedUsers = [];
        let sortField = 'name';
        let sortDirection = 'asc';

        document.addEventListener('DOMContentLoaded', function() {
            // Configuration CSRF pour Axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            // Initialiser les écouteurs d'événements
            setupEventListeners();
        });

        function setupEventListeners() {
            // Recherche en temps réel
            document.getElementById('admin-search-users').addEventListener('input', debounce(handleSearch, 500));

            // Filtre par rôle
            document.getElementById('admin-filter-role').addEventListener('change', handleRoleFilter);

            // Fermeture des modals en cliquant à côté - CORRECTION ICI
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('admin-modal')) {
                    closeAllModals();
                }
            });

            // Gestion des touches clavier
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllModals();
                }
            });

            // Empêcher la fermeture accidentelle des modals - NOUVEAU
            document.addEventListener('click', function(e) {
                // Empêcher la fermeture si on clique sur des éléments du modal
                if (e.target.closest('.admin-modal-content')) {
                    e.stopPropagation();
                }
            });
        }

        /**
         * Fonction utilitaire de debounce pour la recherche
         */
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        /**
         * Gestion de la recherche
         */
        function handleSearch() {
            const searchTerm = document.getElementById('admin-search-users').value;
            const currentUrl = new URL(window.location);

            if (searchTerm) {
                currentUrl.searchParams.set('search', searchTerm);
            } else {
                currentUrl.searchParams.delete('search');
            }

            window.location.href = currentUrl.toString();
        }

        /**
         * Gestion du filtre par rôle
         */
        function handleRoleFilter() {
            const roleFilter = document.getElementById('admin-filter-role').value;
            const currentUrl = new URL(window.location);

            if (roleFilter) {
                currentUrl.searchParams.set('role', roleFilter);
            } else {
                currentUrl.searchParams.delete('role');
            }

            window.location.href = currentUrl.toString();
        }

        /**
         * Actualiser la page
         */
        function refreshUsers() {
            window.location.reload();
        }

        /**
         * Exporter les utilisateurs
         */
        function exportUsers() {
            window.open('/admin/users/export', '_blank');
        }

        /**
         * Gestion de la sélection multiple
         */
        function toggleSelectAll() {
            const selectAll = document.getElementById('admin-select-all');
            const checkboxes = document.querySelectorAll('.admin-user-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });

            updateSelection();
        }

        function updateSelection() {
            const checkboxes = document.querySelectorAll('.admin-user-checkbox:checked');
            selectedUsers = Array.from(checkboxes).map(cb => parseInt(cb.value));

            const bulkActions = document.getElementById('admin-bulk-actions');
            const selectedCount = document.getElementById('admin-selected-count');

            if (selectedUsers.length > 0) {
                bulkActions.style.display = 'flex';
                selectedCount.textContent = selectedUsers.length;
            } else {
                bulkActions.style.display = 'none';
            }

            // Mise à jour du checkbox "Sélectionner tout"
            const selectAll = document.getElementById('admin-select-all');
            const totalCheckboxes = document.querySelectorAll('.admin-user-checkbox').length;
            selectAll.checked = selectedUsers.length === totalCheckboxes;
            selectAll.indeterminate = selectedUsers.length > 0 && selectedUsers.length < totalCheckboxes;
        }

        function clearSelection() {
            selectedUsers = [];
            document.querySelectorAll('.admin-user-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('admin-select-all').checked = false;
            document.getElementById('admin-bulk-actions').style.display = 'none';
        }

        /**
         * Actions en lot
         */
        function bulkChangeRole() {
            if (selectedUsers.length === 0) return;

            showModal('admin-role-modal', 'Changer le rôle - Action groupée', `
            <div class="admin-form-group">
                <label><i class="fas fa-shield-alt"></i> Nouveau rôle pour ${selectedUsers.length} utilisateur(s) :</label>
                <select id="admin-bulk-role" class="admin-form-control">
                    <option value="">Sélectionner un rôle</option>
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            <div class="admin-modal-buttons">
                <button class="admin-btn admin-btn-success" onclick="confirmBulkRoleChange()">
                    <i class="fas fa-save"></i> Appliquer
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="closeAllModals()">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </div>
        `);
        }

        async function confirmBulkRoleChange() {
            const newRole = document.getElementById('admin-bulk-role').value;
            if (!newRole) {
                showAlert('Veuillez sélectionner un rôle', 'error');
                return;
            }

            try {
                await axios.post('/admin/users/bulk-role', {
                    user_ids: selectedUsers,
                    role: newRole
                });

                showAlert(`Rôle mis à jour pour ${selectedUsers.length} utilisateur(s)`, 'success');
                closeAllModals();
                setTimeout(() => window.location.reload(), 1500);
            } catch (error) {
                console.error('Erreur:', error);
                showAlert('Erreur lors de la mise à jour des rôles', 'error');
            }
        }

        function bulkDeleteUsers() {
            if (selectedUsers.length === 0) return;

            if (confirm(
                    `Êtes-vous sûr de vouloir supprimer ${selectedUsers.length} utilisateur(s) ?\n\nCette action est irréversible !`
                    )) {
                performBulkDelete();
            }
        }

        async function performBulkDelete() {
            try {
                await axios.post('/admin/users/bulk-delete', {
                    user_ids: selectedUsers
                });

                showAlert(`${selectedUsers.length} utilisateur(s) supprimé(s)`, 'success');
                setTimeout(() => window.location.reload(), 1500);
            } catch (error) {
                console.error('Erreur:', error);
                showAlert('Erreur lors de la suppression', 'error');
            }
        }

        /**
         * Édition du rôle individuel
         */
        function editRole(userId, currentRole) {
            // Empêcher la propagation de l'événement
            event.stopPropagation();

            showModal('admin-role-modal', 'Modifier le rôle utilisateur', `
            <div class="admin-form-group">
                <label><i class="fas fa-shield-alt"></i> Rôle actuel : <strong>${currentRole === 'admin' ? 'Administrateur' : 'Utilisateur'}</strong></label>
                <select id="admin-user-role" class="admin-form-control">
                    <option value="user" ${currentRole === 'user' ? 'selected' : ''}>Utilisateur</option>
                    <option value="admin" ${currentRole === 'admin' ? 'selected' : ''}>Administrateur</option>
                </select>
            </div>
            <div class="admin-role-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Les administrateurs ont accès à toutes les fonctionnalités du système.</p>
            </div>
            <div class="admin-modal-buttons">
                <button class="admin-btn admin-btn-success" onclick="updateUserRole(${userId}); event.stopPropagation();">
                    <i class="fas fa-save"></i> Modifier
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="closeAllModals(); event.stopPropagation();">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </div>
        `);
        }

        async function updateUserRole(userId) {
            const newRole = document.getElementById('admin-user-role').value;

            try {
                await axios.patch(`/admin/users/${userId}/role`, {
                    role: newRole
                });

                showAlert('Rôle utilisateur mis à jour avec succès', 'success');
                closeAllModals();
                setTimeout(() => window.location.reload(), 1500);
            } catch (error) {
                console.error('Erreur:', error);
                const message = error.response?.data?.message || 'Erreur lors de la mise à jour du rôle';
                showAlert(message, 'error');
            }
        }

        /**
         * Édition d'utilisateur
         */
        async function editUser(userId) {
            try {
                // Récupérer les données de l'utilisateur
                const response = await axios.get(`/admin/users/${userId}/data`);
                const user = response.data.user;

                showModal('admin-edit-modal', `Modifier l'utilisateur : ${user.name}`, `
                <div class="admin-form-group">
                    <label><i class="fas fa-user"></i> Nom complet *</label>
                    <input type="text" id="admin-edit-name" value="${user.name}" required>
                </div>
                <div class="admin-form-group">
                    <label><i class="fas fa-envelope"></i> Adresse email *</label>
                    <input type="email" id="admin-edit-email" value="${user.email}" required>
                </div>
                <div class="admin-form-group">
                    <label><i class="fas fa-shield-alt"></i> Rôle</label>
                    <select id="admin-edit-role">
                        <option value="user" ${user.role === 'user' ? 'selected' : ''}>Utilisateur</option>
                        <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Administrateur</option>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label><i class="fas fa-lock"></i> Nouveau mot de passe (laisser vide si inchangé)</label>
                    <input type="password" id="admin-edit-password" placeholder="Nouveau mot de passe">
                </div>
                <div class="admin-form-group">
                    <label><i class="fas fa-lock"></i> Confirmer le mot de passe</label>
                    <input type="password" id="admin-edit-password-confirm" placeholder="Confirmer le mot de passe">
                </div>
                <div class="admin-modal-buttons">
                    <button class="admin-btn admin-btn-success" onclick="updateUserComplete(${userId})">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <button class="admin-btn admin-btn-secondary" onclick="closeAllModals()">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                </div>
            `);
            } catch (error) {
                console.error('Erreur lors du chargement des données utilisateur:', error);
                showAlert('Erreur lors du chargement des données utilisateur', 'error');
            }
        }

        async function updateUserComplete(userId) {
            const name = document.getElementById('admin-edit-name').value.trim();
            const email = document.getElementById('admin-edit-email').value.trim();
            const role = document.getElementById('admin-edit-role').value;
            const password = document.getElementById('admin-edit-password').value;
            const passwordConfirm = document.getElementById('admin-edit-password-confirm').value;

            if (!name || !email) {
                showAlert('Le nom et l\'email sont obligatoires', 'error');
                return;
            }

            if (password && password !== passwordConfirm) {
                showAlert('Les mots de passe ne correspondent pas', 'error');
                return;
            }

            try {
                const data = {
                    name: name,
                    email: email,
                    role: role
                };

                if (password) {
                    data.password = password;
                    data.password_confirmation = passwordConfirm;
                }

                await axios.put(`/admin/users/${userId}`, data);

                showAlert('Utilisateur mis à jour avec succès', 'success');
                closeAllModals();
                setTimeout(() => window.location.reload(), 1500);
            } catch (error) {
                console.error('Erreur:', error);
                const message = error.response?.data?.message || 'Erreur lors de la mise à jour';
                showAlert(message, 'error');
            }
        }

        /**
         * Suppression d'utilisateur
         */
        function deleteUser(userId, userName) {
            if (confirm(
                    `Êtes-vous sûr de vouloir supprimer l'utilisateur "${userName}" ?\n\nCette action est irréversible !`
                    )) {
                performDeleteUser(userId);
            }
        }

        async function performDeleteUser(userId) {
            try {
                await axios.delete(`/admin/users/${userId}`);

                showAlert('Utilisateur supprimé avec succès', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } catch (error) {
                console.error('Erreur:', error);
                const message = error.response?.data?.message || 'Erreur lors de la suppression';
                showAlert(message, 'error');
            }
        }

        /**
         * Tri du tableau
         */
        function sortTable(field) {
            if (sortField === field) {
                sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                sortField = field;
                sortDirection = 'asc';
            }

            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('sort', sortField);
            currentUrl.searchParams.set('direction', sortDirection);

            window.location.href = currentUrl.toString();
        }

        /**
         * Gestion des modals
         */
        function showModal(modalId, title, content) {
            const modal = document.getElementById(modalId);
            const titleElement = modal.querySelector('.admin-modal-header h3');
            const contentElement = modal.querySelector('.admin-modal-body > div');

            titleElement.textContent = title;
            contentElement.innerHTML = content;
            modal.style.display = 'block';
        }

        function closeAllModals() {
            const modals = document.querySelectorAll('.admin-modal');
            modals.forEach(modal => {
                modal.style.display = 'none';
            });
        }

        /**
         * Système d'alertes
         */
        function showAlert(message, type = 'success') {
            const alertsContainer = document.getElementById('admin-alerts-container');
            const icons = {
                'success': 'fas fa-check-circle',
                'error': 'fas fa-exclamation-circle',
                'warning': 'fas fa-exclamation-triangle',
                'info': 'fas fa-info-circle'
            };

            alertsContainer.innerHTML = `
            <div class="admin-alert admin-alert-${type}">
                <i class="${icons[type]}"></i>
                ${message}
                <button class="admin-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

            // Auto-suppression après 5 secondes
            setTimeout(() => {
                const alert = alertsContainer.querySelector('.admin-alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    </script>
@endsection
