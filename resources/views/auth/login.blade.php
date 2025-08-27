<x-guest-layout>
    @section('title', 'Connexion')
    
    <!-- Session Status -->
    @if (session('status'))
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
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
                autocomplete="username"
                placeholder="votre.email@hrtelecoms.fr"
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
                <i class="fas fa-lock"></i> Mot de passe
            </label>
            <input 
                id="password" 
                class="form-input @error('password') error @enderror"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Votre mot de passe sécurisé"
            >
            @error('password')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="remember-me">
            <input 
                id="remember_me" 
                type="checkbox" 
                name="remember"
                {{ old('remember') ? 'checked' : '' }}
            >
            <label for="remember_me">Se souvenir de moi</label>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </div>

        @if (Route::has('password.request'))
            <div style="text-align: center; margin-top: 15px;">
                <a class="btn-link" href="{{ route('password.request') }}">
                    <i class="fas fa-key"></i> Mot de passe oublié ?
                </a>
            </div>
        @endif
    </form>

    <x-slot name="footer">
        <p style="color: #6c757d; margin: 0; font-size: 0.9em;">
            <i class="fas fa-shield-alt"></i> 
            Connexion sécurisée SSL - Vos données sont protégées
        </p>
        
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