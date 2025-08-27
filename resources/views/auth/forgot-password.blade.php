<x-guest-layout>
    @section('title', 'Mot de passe oublié')
    
    <!-- Session Status -->
    @if (session('status'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <div style="text-align: center; margin-bottom: 25px;">
        <i class="fas fa-key" style="font-size: 3em; color: var(--primary-color); margin-bottom: 15px;"></i>
        <h2 style="color: var(--dark-color); margin: 0 0 10px 0; font-family: 'Poppins', sans-serif;">
            Mot de passe oublié ?
        </h2>
        <p style="color: var(--medium-gray); margin: 0; line-height: 1.5;">
            Pas de problème ! Saisissez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

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
                autofocus
                placeholder="votre.email@entreprise.fr"
            >
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
            </button>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a class="btn-link" href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i> Retour à la connexion
            </a>
        </div>
    </form>

    <x-slot name="footer">
        <div style="background: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 6px; border-left: 4px solid #17a2b8;">
            <i class="fas fa-clock"></i> 
            <strong>Temps d'attente :</strong> Le lien de réinitialisation sera valide pendant 60 minutes.
        </div>
        
        <div class="divider">
            <span>Problème persistant ?</span>
        </div>
        
        <p style="margin: 0; font-size: 0.9em;">
            <a href="mailto:supporttechnique@hrtelecoms.fr" class="btn-link">
                <i class="fas fa-headset"></i> Contactez notre support technique
            </a><br>
            <small style="color: var(--medium-gray); margin-top: 5px; display: inline-block;">
                Nous vous aiderons à récupérer l'accès à votre compte
            </small>
        </p>
    </x-slot>
</x-guest-layout>