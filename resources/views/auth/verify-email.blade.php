<x-guest-layout>
    @section('title', 'Vérifier votre email')
    
    @if (session('status') == 'verification-link-sent')
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> 
            Un nouveau lien de vérification a été envoyé à votre adresse email !
        </div>
    @endif

    <div style="text-align: center; margin-bottom: 25px;">
        <i class="fas fa-envelope-open" style="font-size: 3em; color: var(--warning-color); margin-bottom: 15px;"></i>
        <h2 style="color: var(--dark-color); margin: 0 0 10px 0; font-family: 'Poppins', sans-serif;">
            Vérifiez votre email
        </h2>
        <p style="color: var(--medium-gray); margin: 0 0 15px 0; line-height: 1.5;">
            Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.
        </p>
        <div style="background: var(--primary-ultra-light); padding: 12px; border-radius: 8px; border-left: 4px solid var(--primary-color);">
            <i class="fas fa-user-circle"></i> 
            <strong>{{ Auth::user()->email }}</strong>
        </div>
    </div>

    <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #ffc107;">
        <i class="fas fa-clock"></i>
        <strong>Email non reçu ?</strong><br>
        Vérifiez vos spams ou utilisez le bouton ci-dessous pour renvoyer le lien de vérification.
    </div>

    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <!-- Renvoyer le lien -->
        <form method="POST" action="{{ route('verification.send') }}" style="flex: 1;">
            @csrf
            <button type="submit" class="btn-primary" style="width: 100%;">
                <i class="fas fa-paper-plane"></i> Renvoyer l'email de vérification
            </button>
        </form>

        <!-- Se déconnecter -->
        <form method="POST" action="{{ route('logout') }}" style="flex: 1;">
            @csrf
            <button type="submit" class="btn-primary" 
                    style="width: 100%; background: linear-gradient(135deg, var(--medium-gray), #5a6268);">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </button>
        </form>
    </div>

    <x-slot name="footer">
        <div style="background: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 6px; border-left: 4px solid #17a2b8;">
            <i class="fas fa-shield-alt"></i> 
            <strong>Sécurité :</strong> Cette étape garantit que vous êtes le propriétaire de cette adresse email et sécurise votre compte.
        </div>
        
        <div class="divider">
            <span>Instructions détaillées</span>
        </div>
        
        <div style="font-size: 0.9em; color: var(--medium-gray); text-align: left;">
            <ol style="margin: 0; padding-left: 20px; line-height: 1.6;">
                <li>Vérifiez votre boîte de réception email</li>
                <li>Cherchez un email de <strong>HR TELECOMS</strong></li>
                <li>Cliquez sur le lien "Vérifier mon adresse email"</li>
                <li>Vous serez redirigé vers votre dashboard</li>
            </ol>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                <p style="margin: 0;">
                    <i class="fas fa-question-circle"></i> 
                    <strong>Toujours des problèmes ?</strong><br>
                    <a href="mailto:supporttechnique@hrtelecoms.fr" class="btn-link">
                        Contactez notre support technique
                    </a> - nous vous aiderons immédiatement.
                </p>
            </div>
        </div>
    </x-slot>
</x-guest-layout>