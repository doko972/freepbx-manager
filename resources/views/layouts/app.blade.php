<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FreePBX Manager Professional')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>

    <header class="main-header">
        <div class="header-top">
            <div class="container">
                <div class="header-contact">
                    <span><i class="fas fa-envelope"></i> supporttechnique@hrtelecoms.fr</span>
                    <span><i class="fas fa-phone"></i> +33 (0)2 31 43 04 17</span>
                    <span><i class="fas fa-clock"></i> Lun-Ven 9h-12h / 14h-18h00</span>
                </div>
            </div>
        </div>

        <div class="header-main">
            <div class="container">
                <div class="logo-section">
                    <div class="logo-container">
                        <img src="{{ asset('images/logo.png') }}" alt="HR TELECOMS" class="company-logo">
                    </div>
                    <div class="logo-text">
                        <div class="logo-title">FreePBX Manager</div>
                    </div>
                </div>

                <div class="header-actions">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-info">
                            <span>{{ Auth::user()->name }}</span>
                            @if (Auth::user()->role === 'admin')
                                <small style="color: #ffc107;"><i class="fas fa-crown"></i> Administrateur</small>
                            @else
                                <small>Utilisateur</small>
                            @endif
                        </div>
                        <div class="user-menu">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <div class="breadcrumb">
                <a href="/"><i class="fas fa-home"></i> Accueil</a>
                <i class="fas fa-chevron-right"></i>
                <span>@yield('breadcrumb', 'Dashboard')</span>
            </div>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <div class="main-container">
        <div class="content-wrapper">
            <div class="content-header">
                <h1 class="page-title">
                    @yield('page-title', 'Dashboard Clients')
                </h1>
                <p class="page-subtitle">@yield('page-subtitle', 'Gérez vos clients et leurs infrastructures téléphoniques')</p>
            </div>

            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer Principal -->
    <footer class="main-footer">
        <div class="footer-main">
            <div class="container">
                <div class="footer-section">
                    <img src="{{ asset('images/Logo_hr.png') }}" alt="HR TELECOMS" class="footer-logo">
                    <h4>HR TELECOMS</h4>
                    <p>Spécialiste des solutions téléphoniques professionnelles. Expert FreePBX et infrastructures VoIP.
                    </p>
                    <a href="https://ateliernormandduweb.fr/" target="_blank" class="footer-link button-style">
                        <i class="fas fa-globe"></i>
                        Conçu par: Atelier Normand du Web
                    </a>
                </div>

                <div class="footer-section">
                    <h4>Contact</h4>
                    <a href="mailto:supporttechnique@hrtelecoms.fr" class="footer-link bordered">
                        <i class="fas fa-envelope"></i>
                        supporttechnique@hrtelecoms.fr
                    </a>
                    <a href="tel:+33231430417" class="footer-link bordered">
                        <i class="fas fa-phone"></i>
                        +33 (0)2 31 43 04 17
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div>
                    © 2025 HR TELECOMS. Tous droits réservés.
                </div>
    </footer>

    @yield('scripts')
</body>

</html>
