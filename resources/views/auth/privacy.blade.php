<x-guest-layout>
    @section('title', 'Politique de confidentialité')
    
    <div style="text-align: center; margin-bottom: 30px;">
        <i class="fas fa-user-shield" style="font-size: 3em; color: var(--primary-color); margin-bottom: 15px;"></i>
        <h2 style="color: var(--dark-color); margin: 0 0 10px 0; font-family: 'Poppins', sans-serif;">
            Politique de confidentialité
        </h2>
        <p style="color: var(--medium-gray); margin: 0; font-size: 0.9em;">
            FreePBX Manager Professional - HRTélécoms
        </p>
        <p style="color: var(--medium-gray); margin: 5px 0 0 0; font-size: 0.85em;">
            Conforme au RGPD - Dernière mise à jour : {{ date('d/m/Y') }}
        </p>
    </div>

    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #28a745;">
        <i class="fas fa-shield-alt"></i>
        <strong>Engagement de confidentialité :</strong> HRTélécoms s'engage à protéger et respecter votre vie privée.
    </div>

    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin-bottom: 25px; font-size: 0.9em; line-height: 1.6;">
        
        <h3 style="color: var(--primary-color); margin-bottom: 15px; font-size: 1.1em;">
            <i class="fas fa-info-circle"></i> 1. Responsable du traitement
        </h3>
        <p>
            <strong>HRTélécoms</strong><br>
            Adresse : 16 IMP BANVILLE 14320 LAIZE-CLINCHAMPS<br>
            Téléphone : +33 (0)2 31 43 50 11<br>
            Email : supporttechnique@hrtelecoms.fr<br>
            SIRET : 78925674000042
        </p>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-database"></i> 2. Données collectées
        </h3>
        <p><strong>Données d'identification :</strong></p>
        <ul style="padding-left: 20px;">
            <li>Nom et prénom</li>
            <li>Adresse email professionnelle</li>
            <li>Mot de passe (chiffré)</li>
            <li>Rôle utilisateur (admin/user)</li>
        </ul>

        <p><strong>Données techniques :</strong></p>
        <ul style="padding-left: 20px;">
            <li>Adresse IP de connexion</li>
            <li>Journaux de connexion (logs)</li>
            <li>Données de navigation (cookies techniques)</li>
            <li>Informations sur le navigateur et l'appareil</li>
        </ul>

        <p><strong>Données professionnelles saisies :</strong></p>
        <ul style="padding-left: 20px;">
            <li>Informations clients (noms, coordonnées)</li>
            <li>Structures d'entreprises (sociétés, filiales)</li>
            <li>Configuration téléphonique (numéros, extensions)</li>
            <li>Inventaire d'équipements</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-bullseye"></i> 3. Finalités du traitement
        </h3>
        <p>Vos données sont traitées pour :</p>
        <ul style="padding-left: 20px;">
            <li><strong>Gestion des comptes :</strong> Authentification et autorisation</li>
            <li><strong>Fonctionnalités du service :</strong> Gestion des infrastructures FreePBX</li>
            <li><strong>Support technique :</strong> Assistance et dépannage</li>
            <li><strong>Sécurité :</strong> Prévention des accès non autorisés</li>
            <li><strong>Obligations légales :</strong> Conservation des logs de connexion</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-gavel"></i> 4. Base légale du traitement
        </h3>
        <ul style="padding-left: 20px;">
            <li><strong>Exécution du contrat :</strong> Fourniture du service FreePBX Manager</li>
            <li><strong>Intérêt légitime :</strong> Sécurité du système et support technique</li>
            <li><strong>Consentement :</strong> Cookies non essentiels (si applicable)</li>
            <li><strong>Obligation légale :</strong> Conservation des logs de connexion</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-share-alt"></i> 5. Destinataires des données
        </h3>
        <p>Vos données ne sont partagées qu'avec :</p>
        <ul style="padding-left: 20px;">
            <li><strong>Personnel autorisé :</strong> Équipe technique HRTélécoms</li>
            <li><strong>Sous-traitants :</strong> Hébergeur sécurisé OVHCloud</li>
            <li><strong>Autorités :</strong> Sur réquisition judiciaire uniquement</li>
        </ul>
        
        <div style="background: rgba(231, 76, 60, 0.1); padding: 12px; border-radius: 6px; margin: 15px 0;">
            <i class="fas fa-times-circle" style="color: var(--danger-color);"></i>
            <strong>Aucune vente :</strong> Nous ne vendons jamais vos données à des tiers.
        </div>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-clock"></i> 6. Durée de conservation
        </h3>
        <ul style="padding-left: 20px;">
            <li><strong>Comptes actifs :</strong> Pendant toute la durée d'utilisation</li>
            <li><strong>Comptes supprimés :</strong> 30 jours puis suppression définitive</li>
            <li><strong>Logs de connexion :</strong> 12 mois (obligation légale)</li>
            <li><strong>Données de sauvegarde :</strong> 90 jours maximum</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-lock"></i> 7. Sécurité des données
        </h3>
        <p>Mesures de protection mises en place :</p>
        <ul style="padding-left: 20px;">
            <li>Chiffrement SSL/TLS pour toutes les transmissions</li>
            <li>Chiffrement des mots de passe (hash bcrypt)</li>
            <li>Serveurs sécurisés en France</li>
            <li>Accès restreint aux données par authentification forte</li>
            <li>Sauvegardes chiffrées et géoredondantes</li>
            <li>Surveillance continue des accès</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-user-cog"></i> 8. Vos droits RGPD
        </h3>
        <p>Vous disposez des droits suivants :</p>
        <ul style="padding-left: 20px;">
            <li><strong>Accès :</strong> Connaître les données que nous détenons</li>
            <li><strong>Rectification :</strong> Corriger des données inexactes</li>
            <li><strong>Suppression :</strong> Supprimer vos données ("droit à l'oubli")</li>
            <li><strong>Portabilité :</strong> Récupérer vos données dans un format lisible</li>
            <li><strong>Opposition :</strong> Vous opposer au traitement</li>
            <li><strong>Limitation :</strong> Restreindre le traitement</li>
        </ul>

        <div style="background: var(--primary-ultra-light); padding: 12px; border-radius: 6px; margin: 15px 0;">
            <i class="fas fa-envelope" style="color: var(--primary-color);"></i>
            <strong>Exercer vos droits :</strong> supporttechnique@hrtelecoms.fr
        </div>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-cookie-bite"></i> 9. Cookies et traceurs
        </h3>
        <p><strong>Cookies techniques (obligatoires) :</strong></p>
        <ul style="padding-left: 20px;">
            <li>Authentification et session utilisateur</li>
            <li>Préférences d'interface</li>
            <li>Protection CSRF (sécurité)</li>
        </ul>

        <h3 style="color: var(--primary-color); margin: 25px 0 15px 0; font-size: 1.1em;">
            <i class="fas fa-globe-europe"></i> 10. Transferts internationaux
        </h3>
        <p>
            Toutes vos données sont hébergées en France ou dans l'Union Européenne. Aucun transfert vers des pays tiers n'est effectué sans garanties adéquates.
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
            <i class="fas fa-shield-alt"></i> 
            <strong>Protection maximale :</strong> Vos données sont traitées selon les standards les plus stricts du RGPD. Aucune données personnelles n'est traités et/ou conservés.
        </div>
        
        <p style="margin: 15px 0 0 0; font-size: 0.85em; color: var(--medium-gray);">
            HRTélécoms s'engage pour la protection de votre vie privée<br>
        </p>
    </x-slot>
</x-guest-layout>