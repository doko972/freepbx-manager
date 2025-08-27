<x-guest-layout>
    @section('title', 'Conditions d\'utilisation')
    
    <div style="text-align: center; margin-bottom: 30px;">
        <i class="fas fa-file-contract" style="font-size: 3em; color: var(--primary-color); margin-bottom: 15px;"></i>
        <h2 style="color: var(--dark-color); margin: 0 0 10px 0; font-family: 'Poppins', sans-serif;">
            Conditions d'utilisation
        </h2>
        <p style="color: var(--medium-gray); margin: 0; font-size: 0.9em;">
            FreePBX Manager - HRTélécoms
        </p>
        <p style="color: var(--medium-gray); margin: 5px 0 0 0; font-size: 0.85em;">
            Dernière mise à jour : {{ date('d/m/Y') }}
        </p>
    </div>

    <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #ffc107;">
        <i class="fas fa-info-circle"></i>
        <strong>Information importante :</strong> En utilisant FreePBX Manager, vous acceptez les conditions suivantes.
    </div>

    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin-bottom: 25px; font-size: 0.9em; line-height: 1.6;">
        
        <h3 style="color: var(--primary-color); margin-bottom: 15px; font-size: 1.1em;">
            <i class="fas fa-gavel"></i> 1. Objet et acceptation
        </h3>
        <p>
            Les présentes conditions générales d'utilisation régissent l'accès et l'utilisation de la plateforme FreePBX Manager Professional, éditée par HRTélécoms. En créant un compte ou en utilisant nos services, vous acceptez sans réserve ces conditions.
        </p>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-user-shield"></i> 2. Inscription et comptes utilisateur
        </h3>
        <ul style="padding-left: 20px;">
            <li>L'inscription est gratuite et réservée aux professionnels</li>
            <li>Les informations fournies doivent être exactes et à jour</li>
            <li>Chaque utilisateur est responsable de la confidentialité de ses identifiants</li>
            <li>Les comptes administrateur nécessitent une validation par HRTélécoms</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-tasks"></i> 3. Description des services
        </h3>
        <p>
            FreePBX Manager permet de gérer vos infrastructures téléphoniques FreePBX :
        </p>
        <ul style="padding-left: 20px;">
            <li>Gestion hiérarchique des clients, sociétés et filiales</li>
            <li>Administration des numéros de téléphone et extensions</li>
            <li>Inventaire des équipements téléphoniques</li>
            <li>Génération de rapports PDF personnalisés</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-exclamation-triangle"></i> 4. Obligations et interdictions
        </h3>
        <p><strong>Vous vous engagez à :</strong></p>
        <ul style="padding-left: 20px;">
            <li>Utiliser le service dans un cadre professionnel légal</li>
            <li>Respecter la confidentialité des données clients</li>
            <li>Ne pas tenter de compromettre la sécurité de la plateforme</li>
            <li>Signaler toute anomalie ou faille de sécurité</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-database"></i> 5. Données et sauvegarde
        </h3>
        <p>
            HRTélécoms met en œuvre les moyens techniques nécessaires pour assurer la disponibilité du service. Toutefois, il est recommandé de maintenir des sauvegardes régulières de vos données importantes.
        </p>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-shield-alt"></i> 6. Limitation de responsabilité
        </h3>
        <p>
            HRTélécoms ne pourra être tenue responsable des dommages indirects résultant de l'utilisation du service. Notre responsabilité est limitée aux dommages directs prouvés dans la limite des sommes versées.
        </p>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-copyright"></i> 7. Propriété intellectuelle
        </h3>
        <p>
            Le logiciel FreePBX Manager, sa conception, ses fonctionnalités et son interface sont la propriété exclusive de HRTélécoms. Toute reproduction ou utilisation non autorisée est interdite.
        </p>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-ban"></i> 8. Résiliation
        </h3>
        <p>
            HRTélécoms se réserve le droit de suspendre ou supprimer un compte en cas de non-respect des présentes conditions, sans préavis ni indemnité.
        </p>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-balance-scale"></i> 9. Droit applicable
        </h3>
        <p>
            Les présentes conditions sont soumises au droit français. En cas de litige, les tribunaux de Caen seront seuls compétents.
        </p>

    </div>

    <div style="text-align: center;">
        <a href="{{ route('register') }}" class="btn-primary" style="display: inline-block; margin-right: 15px;">
            <i class="fas fa-check"></i> J'accepte et je continue l'inscription
        </a>
        <a href="{{ route('login') }}" class="btn-link">
            <i class="fas fa-arrow-left"></i> Retour à la connexion
        </a>
    </div>

    <x-slot name="footer">
        <div style="background: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 6px; border-left: 4px solid #17a2b8;">
            <i class="fas fa-phone"></i> 
            <strong>Questions ?</strong> Contactez-nous au <br>+33 (0)2 31 43 50 11
        </div>
        
        <p style="margin: 15px 0 64px 0; font-size: 0.85em; color: var(--medium-gray);">
            HRTélécoms - 16 IMP BANVILLE <br>14320 LAIZE-CLINCHAMPS, France<br>
            SIRET : 78925674000042 - APE : 61.10Z
        </p>
    </x-slot>
</x-guest-layout>