<x-guest-layout>
    @section('title', 'Réinitialiser le mot de passe')
    
    <div style="text-align: center; margin-bottom: 25px;">
        <i class="fas fa-shield-alt" style="font-size: 3em; color: var(--success-color); margin-bottom: 15px;"></i>
        <h2 style="color: var(--dark-color); margin: 0 0 10px 0; font-family: 'Poppins', sans-serif;">
            Nouveau mot de passe
        </h2>
        <p style="color: var(--medium-gray); margin: 0; line-height: 1.5;">
            Choisissez un mot de passe fort et sécurisé pour votre compte FreePBX Manager.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                value="{{ old('email', $request->email) }}" 
                required 
                autofocus 
                autocomplete="username"
                readonly
                style="background-color: #f8f9fa; cursor: not-allowed;"
            >
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">
                <i class="fas fa-lock"></i> Nouveau mot de passe
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
            <div style="font-size: 0.85em; color: var(--medium-gray); margin-top: 5px;">
                <i class="fas fa-info-circle"></i> 
                Utilisez au moins 8 caractères avec majuscules, minuscules et chiffres
            </div>
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
                placeholder="Répétez le mot de passe"
            >
            @error('password_confirmation')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Réinitialiser le mot de passe
            </button>
        </div>
    </form>

    <x-slot name="footer">
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> 
            <strong>Sécurité renforcée :</strong> Une fois modifié, vous serez automatiquement connecté avec votre nouveau mot de passe.
        </div>
        
        <div class="divider">
            <span>Conseils de sécurité</span>
        </div>
        
        <div style="font-size: 0.9em; color: var(--medium-gray); text-align: left;">
            <ul style="margin: 0; padding-left: 20px;">
                <li>Utilisez un mot de passe unique pour ce compte</li>
                <li>Évitez les informations personnelles évidentes</li>
                <li>Considérez l'utilisation d'un gestionnaire de mots de passe</li>
            </ul>
        </div>
    </x-slot>
</x-guest-layout>