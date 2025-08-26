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

            <!-- Navigation principale -->
            <nav class="main-navigation">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-users-cog"></i>
                                <span>Administration</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-pdf"></i>
                            <span>Rapports</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Profil utilisateur -->
            <div class="header-actions">
                <div class="user-profile" x-data="{ open: false }">
                    <button @click="open = !open" class="user-trigger">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->role === 'admin')
                                <small class="user-role admin">
                                    <i class="fas fa-crown"></i> Administrateur
                                </small>
                            @else
                                <small class="user-role user">
                                    <i class="fas fa-user"></i> Utilisateur
                                </small>
                            @endif
                        </div>
                        <i class="fas fa-chevron-down user-chevron" :class="{ 'rotated': open }"></i>
                    </button>

                    <!-- Menu déroulant -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         @click.away="open = false"
                         class="user-dropdown">
                        <div class="user-dropdown-header">
                            <div class="user-details">
                                <strong>{{ Auth::user()->name }}</strong>
                                <small>{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                        
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-user-edit"></i>
                                <span>Mon Profil</span>
                            </a>
                            
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Menu mobile -->
                <button class="mobile-menu-toggle" x-data="{ open: false }" @click="open = !open">
                    <div class="hamburger" :class="{ 'active': open }">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation mobile -->
    <div class="mobile-navigation" x-data="{ open: false }" :class="{ 'active': open }">
        <div class="mobile-nav-content">
            <div class="mobile-user-info">
                <div class="mobile-user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="mobile-user-details">
                    <strong>{{ Auth::user()->name }}</strong>
                    <small>{{ Auth::user()->email }}</small>
                    @if(Auth::user()->role === 'admin')
                        <span class="mobile-user-role admin">
                            <i class="fas fa-crown"></i> Administrateur
                        </span>
                    @else
                        <span class="mobile-user-role user">Utilisateur</span>
                    @endif
                </div>
            </div>
            
            <nav class="mobile-nav-menu">
                <a href="{{ route('dashboard') }}" 
                   class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                @if(Auth::user()->isAdmin())
                    <a href="#" class="mobile-nav-item">
                        <i class="fas fa-users-cog"></i>
                        <span>Administration</span>
                    </a>
                @endif
                
                <a href="#" class="mobile-nav-item">
                    <i class="fas fa-file-pdf"></i>
                    <span>Rapports</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="mobile-nav-item">
                    <i class="fas fa-user-edit"></i>
                    <span>Mon Profil</span>
                </a>
                
                <div class="mobile-nav-divider"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-item logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </nav>
        </div>
    </div>
</header>

<style>
/* Variables reprises de votre système */
:root {
    --primary-color: #1d46ef;
    --primary-light: #4d6bef;
    --dark-color: #2c3e50;
    --medium-gray: #6c757d;
    --light-gray: #f8f9fa;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --shadow: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.15);
}

/* Navigation principale */
.main-navigation {
    display: flex;
    align-items: center;
}

.nav-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 10px;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    color: var(--dark-color);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.nav-link:hover {
    background: var(--light-gray);
    color: var(--primary-color);
}

.nav-link.active {
    background: var(--primary-color);
    color: white;
}

/* Profil utilisateur */
.user-profile {
    position: relative;
}

.user-trigger {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 15px;
    background: white;
    border: 2px solid var(--light-gray);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.user-trigger:hover {
    border-color: var(--primary-color);
    box-shadow: var(--shadow);
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2em;
}

.user-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.user-name {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 2px;
}

.user-role {
    font-size: 0.8em;
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 500;
}

.user-role.admin {
    background: var(--warning-color);
    color: var(--dark-color);
}

.user-role.user {
    background: var(--light-gray);
    color: var(--medium-gray);
}

.user-chevron {
    transition: transform 0.3s ease;
    color: var(--medium-gray);
}

.user-chevron.rotated {
    transform: rotate(180deg);
}

/* Menu déroulant */
.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 8px;
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--light-gray);
    min-width: 280px;
    z-index: 1000;
}

.user-dropdown-header {
    padding: 20px;
    border-bottom: 1px solid var(--light-gray);
    background: var(--light-gray);
    border-radius: 12px 12px 0 0;
}

.user-details strong {
    display: block;
    color: var(--dark-color);
    margin-bottom: 4px;
}

.user-details small {
    color: var(--medium-gray);
}

.dropdown-menu {
    padding: 10px 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: var(--dark-color);
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.dropdown-item:hover {
    background: var(--light-gray);
    color: var(--primary-color);
}

.dropdown-item.logout-item {
    color: var(--danger-color);
}

.dropdown-item.logout-item:hover {
    background: rgba(220, 53, 69, 0.1);
}

.dropdown-divider {
    height: 1px;
    background: var(--light-gray);
    margin: 8px 0;
}

/* Menu mobile */
.mobile-menu-toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
}

.hamburger {
    width: 24px;
    height: 18px;
    position: relative;
    transform: rotate(0deg);
    transition: 0.3s ease-in-out;
}

.hamburger span {
    display: block;
    position: absolute;
    height: 3px;
    width: 100%;
    background: var(--dark-color);
    border-radius: 3px;
    opacity: 1;
    left: 0;
    transform: rotate(0deg);
    transition: 0.25s ease-in-out;
}

.hamburger span:nth-child(1) { top: 0; }
.hamburger span:nth-child(2) { top: 7px; }
.hamburger span:nth-child(3) { top: 14px; }

.hamburger.active span:nth-child(1) {
    top: 7px;
    transform: rotate(135deg);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
    left: -60px;
}

.hamburger.active span:nth-child(3) {
    top: 7px;
    transform: rotate(-135deg);
}

/* Navigation mobile */
.mobile-navigation {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-navigation.active {
    opacity: 1;
    visibility: visible;
}

.mobile-nav-content {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 300px;
    background: white;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    overflow-y: auto;
}

.mobile-navigation.active .mobile-nav-content {
    transform: translateX(0);
}

.mobile-user-info {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 30px 20px;
    background: var(--light-gray);
    border-bottom: 1px solid #dee2e6;
}

.mobile-user-avatar {
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4em;
}

.mobile-nav-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
    color: var(--dark-color);
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.mobile-nav-item:hover,
.mobile-nav-item.active {
    background: var(--primary-color);
    color: white;
}

.mobile-nav-item.logout {
    color: var(--danger-color);
    margin-top: 10px;
}

.mobile-nav-divider {
    height: 1px;
    background: var(--light-gray);
    margin: 10px 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .main-navigation {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: block;
    }
    
    .mobile-navigation {
        display: block;
    }
    
    .user-profile .user-trigger {
        display: none;
    }
}

@media (max-width: 992px) {
    .nav-menu {
        gap: 5px;
    }
    
    .nav-link {
        padding: 10px 15px;
    }
    
    .nav-link span {
        display: none;
    }
}
</style>