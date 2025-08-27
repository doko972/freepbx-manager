<x-guest-layout>
    @section('title', 'Confirmer le mot de passe')
    
    <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #ffc107;">
        <i class="fas fa-shield-alt"></i>
        <strong>Sécurité renforcée</strong><br>
        Veuillez confirmer votre mot de passe pour accéder à cette zone sécurisée.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="form-group">
            <label for="password">
                <i class="fas fa-lock"></i> Mot de passe actuel
            </label>
            <input 
                id="password" 
                class="form-input @error('password') error @enderror"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Saisissez votre mot de passe"
                autofocus
            >
            @error('password')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-check-circle"></i> Confirmer
            </button>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a class="btn-link" href="{{ url()->previous() }}">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </form>

    <x-slot name="footer">
        <div style="background: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 6px; border-left: 4px solid #17a2b8;">
            <i class="fas fa-info-circle"></i> 
            Cette vérification garantit que vous êtes bien le propriétaire de ce compte avant d'accéder aux fonctionnalités sensibles.
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