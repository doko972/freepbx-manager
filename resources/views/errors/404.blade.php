@extends('layouts.app')

@section('title', 'Page introuvable - FreePBX Manager Professional')
@section('breadcrumb', 'Erreur 404')
@section('page-title', 'Page introuvable')
@section('page-subtitle', 'La page que vous cherchez semble avoir disparu')

@section('content')
<div class="error-404-container">
    
    <!-- Section principale de l'erreur -->
    <div class="error-main-section">
        <!-- Code d'erreur animé -->
        <div class="error-code-section">
            <div class="error-code-wrapper">
                <div class="error-digit error-4-1">4</div>
                <div class="error-digit error-0">
                    <div class="error-phone-icon">
                        <i class="fas fa-phone-slash"></i>
                    </div>
                </div>
                <div class="error-digit error-4-2">4</div>
            </div>
            <div class="error-signal-bars">
                <div class="signal-bar bar-1"></div>
                <div class="signal-bar bar-2"></div>
                <div class="signal-bar bar-3"></div>
                <div class="signal-bar bar-4"></div>
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="error-message-section">
            <h1>Connexion impossible</h1>
            <p class="error-description">
                La page demandée n'a pas pu être localisée sur nos serveurs FreePBX. 
                Elle a peut-être été déplacée, supprimée ou l'URL est incorrecte.
            </p>
            <div class="error-suggestions">
                <h3><i class="fas fa-lightbulb"></i> Suggestions :</h3>
                <ul>
                    <li>Vérifiez l'orthographe de l'URL</li>
                    <li>Utilisez le menu de navigation</li>
                    <li>Retournez à la page d'accueil</li>
                    <li>Contactez le support technique si le problème persiste</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="error-actions-section">
        <div class="action-cards">
            @if(Auth::check())
                <a href="{{ url('/dashboard') }}" class="action-card primary">
                    <div class="card-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-content">
                        <h4>Dashboard</h4>
                        <p>Retour au tableau de bord</p>
                    </div>
                    <div class="card-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.users') }}" class="action-card admin">
                    <div class="card-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="card-content">
                        <h4>Administration</h4>
                        <p>Gestion des utilisateurs</p>
                    </div>
                    <div class="card-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="action-card primary">
                    <div class="card-icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="card-content">
                        <h4>Connexion</h4>
                        <p>Accéder à votre compte</p>
                    </div>
                    <div class="card-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('register') }}" class="action-card admin">
                    <div class="card-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="card-content">
                        <h4>Créer un compte</h4>
                        <p>S'inscrire sur la plateforme</p>
                    </div>
                    <div class="card-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            @endif

            <a href="mailto:supporttechnique@hrtelecoms.fr" class="action-card support">
                <div class="card-icon">
                    <i class="fas fa-life-ring"></i>
                </div>
                <div class="card-content">
                    <h4>Support Technique</h4>
                    <p>Besoin d'aide ?</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-external-link-alt"></i>
                </div>
            </a>

            <button onclick="history.back()" class="action-card secondary">
                <div class="card-icon">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="card-content">
                    <h4>Page Précédente</h4>
                    <p>Retour en arrière</p>
                </div>
                <div class="card-arrow">
                    <i class="fas fa-undo"></i>
                </div>
            </button>
        </div>
    </div>

    <!-- Informations techniques -->
    <div class="error-tech-info">
        <div class="tech-card">
            <div class="tech-header">
                <i class="fas fa-info-circle"></i>
                <h4>Informations Techniques</h4>
            </div>
            <div class="tech-details">
                <div class="tech-row">
                    <span class="tech-label">Code d'erreur :</span>
                    <span class="tech-value">HTTP 404</span>
                </div>
                <div class="tech-row">
                    <span class="tech-label">URL demandée :</span>
                    <span class="tech-value">{{ request()->fullUrl() }}</span>
                </div>
                <div class="tech-row">
                    <span class="tech-label">Référent :</span>
                    <span class="tech-value">{{ request()->header('referer', 'Accès direct') }}</span>
                </div>
                <div class="tech-row">
                    <span class="tech-label">Timestamp :</span>
                    <span class="tech-value">{{ now()->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section de navigation rapide -->
    <div class="quick-nav-section">
        <h3><i class="fas fa-sitemap"></i> Navigation Rapide</h3>
        <div class="nav-links">
            @if(Auth::check())
                <a href="{{ url('/dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="fas fa-user-edit"></i>
                    <span>Mon Profil</span>
                </a>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-tools"></i>
                    <span>Administration</span>
                </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Connexion</span>
                </a>
                <a href="{{ route('register') }}" class="nav-link">
                    <i class="fas fa-user-plus"></i>
                    <span>Inscription</span>
                </a>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des barres de signal
    const signalBars = document.querySelectorAll('.signal-bar');
    
    function animateSignalBars() {
        signalBars.forEach((bar, index) => {
            setTimeout(() => {
                bar.style.animationDelay = `${index * 0.1}s`;
                bar.classList.add('animate');
            }, index * 100);
        });
        
        setTimeout(() => {
            signalBars.forEach(bar => {
                bar.classList.remove('animate');
            });
        }, 2000);
    }
    
    // Lancer l'animation au chargement
    setTimeout(animateSignalBars, 500);
    
    // Répéter l'animation toutes les 4 secondes
    setInterval(animateSignalBars, 4000);
    
    // Animation hover sur les cartes
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Animation d'apparition des éléments
    const animateElements = document.querySelectorAll('.error-main-section, .action-cards, .error-tech-info, .quick-nav-section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endsection