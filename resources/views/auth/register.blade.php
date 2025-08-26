<x-guest-layout>
    @section('title', 'Créer un compte')
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">
                <i class="fas fa-user"></i> Nom complet
            </label>
            <input 
                id="name" 
                class="form-input @error('name') error @enderror" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Jean Dupont"
            >
            @error('name')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">
                <i class="fas fa-envelope"></i> Adresse email
            </label>
            <input 
                id="email" 
                class="form-input @error('email') error @enderror" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username"
                placeholder="jean.dupont@entreprise.fr"
            >
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Role Selection -->
        <div class="form-group">
            <label for="role">
                <i class="fas fa-user-tag"></i> Type de compte
            </label>
            <select 
                id="role" 
                name="role" 
                class="form-input @error('role') error @enderror"
                required
            >
                <option value="">Sélectionnez votre profil...</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                    Utilisateur - Gestion de mes infrastructures
                </option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    Administrateur - Gestion complète
                </option>
            </select>
            @error('role')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
            <div style="font-size: 0.85em; color: #6c757d; margin-top: 5px;">
                <i class="fas fa-info-circle"></i> Les comptes administrateur nécessitent une validation
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">
                <i class="fas fa-lock"></i> Mot de passe
            </label>
            <input 
                id="password" 
                class="form-input @error('password') error @enderror"
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="Minimum 8 caractères"
            >
            @error('password')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">
                <i class="fas fa-lock"></i> Confirmer le mot de passe
            </label>
            <input 
                id="password_confirmation" 
                class="form-input @error('password_confirmation') error @enderror"
                type="password"
                name="password_confirmation"
                required 
                autocomplete="new-password"
                placeholder="Répétez votre mot de passe"
            >
            @error('password_confirmation')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Terms and Conditions -->
        <div class="remember-me" style="margin-bottom: 25px;">
            <input 
                id="terms" 
                type="checkbox" 
                name="terms"
                required
            >
            <label for="terms" style="font-size: 0.9em;">
                J'accepte les <a href="#" class="btn-link">conditions d'utilisation</a> et la 
                <a href="#" class="btn-link">politique de confidentialité</a>
            </label>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-user-plus"></i> Créer mon compte
            </button>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <span style="color: #6c757d;">Déjà un compte ? </span>
            <a class="btn-link" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        </div>
    </form>

    <x-slot name="footer">
        <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 6px; border-left: 4px solid #ffc107;">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Important :</strong> Les comptes administrateur sont soumis à validation par l'équipe HR TELECOMS.
        </div>
        
        <div class="divider">
            <span>Besoin d'aide ?</span>
        </div>
        
        <p style="margin: 0;">
            <a href="mailto:supporttechnique@hrtelecoms.fr" class="btn-link">
                <i class="fas fa-headset"></i> Contacter le support technique
            </a>
        </p>
    </x-slot>
</x-guest-layout>