<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreePBX Manager Professional - HR TELECOMS</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1d46ef;
            --primary-light: #4d6bef;
            --primary-ultra-light: #e8ecff;
            --dark-color: #2c3e50;
            --medium-gray: #6c757d;
            --light-gray: #f8f9fa;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
        }

        .hero-auth {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
            margin-top: 16px;
        }

        .hero-content {
            text-align: center;
            color: white;
            max-width: 1000px;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            margin-bottom: 40px;
        }

        .logo-section img {
            max-height: 80px;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5em;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.4em;
            font-weight: 300;
            margin-bottom: 15px;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1em;
            opacity: 0.9;
            margin-bottom: 50px;
            line-height: 1.6;
        }

        .auth-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .btn-auth {
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-primary-auth {
            background: white;
            color: var(--primary-color);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary-auth {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-secondary-auth:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px 25px;
            border-radius: 15px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3em;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .feature-description {
            opacity: 0.9;
            line-height: 1.5;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: -1s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: -3s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 80%;
            animation-delay: -2s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .footer-info {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            color: white;
            padding: 15px 20px;
            text-align: center;
            font-size: 0.9em;
        }

        .footer-info a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-info a:hover {
            text-decoration: underline;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5em;
            }

            .hero-subtitle {
                font-size: 1.2em;
            }

            .auth-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-auth {
                min-width: 250px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="hero-auth">
        <div class="auth-buttons">
            @auth
                <div
                    style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px);">
                    <p style="margin: 0 0 10px 0; opacity: 0.9;">
                        <i class="fas fa-user-circle"></i>
                        Connecté en tant que <strong>{{ Auth::user()->name }}</strong>
                        @if (Auth::user()->role === 'admin')
                            <span
                                style="background: #ffc107; color: #000; padding: 2px 8px; border-radius: 12px; font-size: 0.8em; margin-left: 8px;">
                                <i class="fas fa-crown"></i> Admin
                            </span>
                        @endif
                    </p>
                </div>

                <a href="{{ url('/dashboard') }}" class="btn-auth btn-primary-auth">
                    <i class="fas fa-tachometer-alt"></i>
                    Accéder au Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-auth btn-secondary-auth"
                        style="background: rgba(220, 53, 69, 0.2); border-color: rgba(220, 53, 69, 0.5);">
                        <i class="fas fa-sign-out-alt"></i>
                        Se déconnecter
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-auth btn-primary-auth">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </a>

                <a href="{{ route('register') }}" class="btn-auth btn-secondary-auth">
                    <i class="fas fa-user-plus"></i>
                    Créer un compte
                </a>
            @endauth
        </div>
    </div>
    <div class="hero-section">
        <!-- Formes flottantes décoratives -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="hero-content">
            <div class="logo-section">
                <img src="{{ asset('images/logo.png') }}" alt="HR TELECOMS">
            </div>

            <h1 class="hero-title">FreePBX Manager Professional</h1>
            <p class="hero-subtitle">Solutions téléphoniques professionnelles</p>
            <p class="hero-description">
                Gérez vos infrastructures FreePBX avec simplicité et efficacité.
                Centralisez tous vos clients, leurs sociétés, numéros et équipements dans une interface moderne et
                intuitive.
            </p>

            <div class="auth-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-auth btn-primary-auth">
                        <i class="fas fa-tachometer-alt"></i>
                        Accéder au Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-auth btn-primary-auth">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </a>

                    <a href="{{ route('register') }}" class="btn-auth btn-secondary-auth">
                        <i class="fas fa-user-plus"></i>
                        Créer un compte
                    </a>
                @endauth
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3 class="feature-title">Arbre Hiérarchique</h3>
                    <p class="feature-description">
                        Visualisez et gérez vos sociétés, filiales, numéros et équipements dans un arbre interactif
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Multi-clients</h3>
                    <p class="feature-description">
                        Gérez plusieurs clients avec leurs propres infrastructures téléphoniques
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h3 class="feature-title">Rapports PDF</h3>
                    <p class="feature-description">
                        Générez automatiquement des rapports détaillés et des listes d'équipements
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Sécurisé</h3>
                    <p class="feature-description">
                        Authentification sécurisée avec gestion des rôles administrateur et utilisateur
                    </p>
                </div>
            </div>

            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>supporttechnique@hrtelecoms.fr</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+33 (0)2 31 43 04 17</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Lun-Ven 9h-12h / 14h-18h</span>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-info">
        <p>© 2025 <a href="https://hrtelecoms.fr" target="_blank">HR TELECOMS</a> - Spécialiste des solutions
            téléphoniques FreePBX</p>
    </div>
</body>

</html>
