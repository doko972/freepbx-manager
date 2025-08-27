<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'total_clients' => \App\Models\Client::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        // Version 1 : Juste la base (gardez celle qui fonctionne)
        if (!$request->has('test_features')) {
            $users = User::paginate(15);

            $stats = [
                'total_admins' => User::where('role', 'admin')->count(),
                'recent_users' => collect(),
            ];

            return view('admin.users', compact('users', 'stats'));
        }

        // Version 2 : Ajout progressif des fonctionnalités (seulement si ?test_features=1)
        try {
            $query = User::query();

            // Test 1: Recherche
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Test 2: Filtre par rôle
            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            // Test 3: Tri
            $sortField = $request->get('sort', 'name');
            $sortDirection = $request->get('direction', 'asc');

            $allowedSortFields = ['name', 'email', 'role', 'created_at'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            }

            $users = $query->paginate(15);

            $stats = [
                'total_admins' => User::where('role', 'admin')->count(),
                'recent_users' => User::where('created_at', '>=', now()->subDays(7))->get(),
            ];

            return view('admin.users', compact('users', 'stats'));
        } catch (\Exception $e) {
            dd('Erreur dans la version avancée: ' . $e->getMessage());
        }
    }

    public function updateRole(User $user, Request $request)
    {
        $request->validate([
            'role' => ['required', Rule::in(['admin', 'user'])]
        ]);

        // Empêcher la rétrogradation du dernier admin
        if ($user->isAdmin() && $request->role === 'user' && User::where('role', 'admin')->count() === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de rétrograder le dernier administrateur'
            ], 422);
        }

        $user->update(['role' => $request->role]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rôle utilisateur mis à jour avec succès'
            ]);
        }

        return back()->with('success', 'Rôle utilisateur mis à jour');
    }

    public function deleteUser(User $user, Request $request)
    {
        // Empêcher la suppression du dernier admin
        if ($user->isAdmin() && User::where('role', 'admin')->count() === 1) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer le dernier administrateur'
                ], 422);
            }
            return back()->withErrors(['user' => 'Impossible de supprimer le dernier administrateur']);
        }

        // Empêcher l'auto-suppression
        if ($user->id === Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas supprimer votre propre compte'
                ], 422);
            }
            return back()->withErrors(['user' => 'Vous ne pouvez pas supprimer votre propre compte']);
        }

        $user->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Utilisateur supprimé avec succès'
            ]);
        }

        return back()->with('success', 'Utilisateur supprimé avec succès');
    }

    public function bulkUpdateRole(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'role' => ['required', Rule::in(['admin', 'user'])]
        ]);

        $userIds = collect($request->user_ids);

        // Empêcher de rétrograder tous les admins
        if ($request->role === 'user') {
            $currentAdmins = User::where('role', 'admin')->count();
            $adminsToDowngrade = User::whereIn('id', $userIds)->where('role', 'admin')->count();

            if ($currentAdmins === $adminsToDowngrade) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de rétrograder tous les administrateurs'
                ], 422);
            }
        }

        // Exclure l'utilisateur connecté de l'action en lot
        $userIds = $userIds->filter(function ($id) {
            return $id != Auth::id();
        });

        $updatedCount = User::whereIn('id', $userIds)->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => "Rôle mis à jour pour {$updatedCount} utilisateur(s)"
        ]);
    }

    public function bulkDeleteUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $userIds = collect($request->user_ids);

        // Empêcher l'auto-suppression
        $userIds = $userIds->filter(function ($id) {
            return $id != Auth::id();
        });

        // Vérifier qu'on ne supprime pas tous les admins
        $usersToDelete = User::whereIn('id', $userIds)->get();
        $adminsToDelete = $usersToDelete->where('role', 'admin')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        if ($totalAdmins === $adminsToDelete) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer tous les administrateurs'
            ], 422);
        }

        $deletedCount = User::whereIn('id', $userIds)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} utilisateur(s) supprimé(s)"
        ]);
    }

    public function exportUsers(Request $request)
    {
        $query = User::with('clients');

        // Appliquer les mêmes filtres que la liste
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Rôle',
                'Email vérifié',
                'Nombre de clients',
                'Date d\'inscription',
                'Dernière connexion'
            ]);

            // Données
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role === 'admin' ? 'Administrateur' : 'Utilisateur',
                    $user->email_verified_at ? 'Oui' : 'Non',
                    $user->clients->count(),
                    $user->created_at->format('d/m/Y H:i'),
                    $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getUserData(User $user)
    {
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'clients_count' => $user->clients->count()
            ]
        ]);
    }

    public function updateUser(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => 'nullable|min:8|confirmed'
        ]);

        // Empêcher la rétrogradation du dernier admin
        if ($user->isAdmin() && $request->role === 'user' && User::where('role', 'admin')->count() === 1) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de rétrograder le dernier administrateur'
                ], 422);
            }
            return back()->withErrors(['role' => 'Impossible de rétrograder le dernier administrateur']);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Utilisateur mis à jour avec succès'
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès');
    }
}
