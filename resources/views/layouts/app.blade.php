<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SDG Network Hub') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/assets/app-DrYIl-Dx.css">
    <script type="module" src="/build/assets/app-Bj43h_rG.js" defer></script>
    <link rel="icon" href="/sdg-icon.jpg">
    <script>
        // Initialize theme before page renders to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <div class="site-navbar">
                <a href="{{ route('home') }}" class="brand" style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 12px;">
                    <img src="/sdg-icon.jpg" alt="SDG Network Hub Logo" style="height: 64px; width: 64px; object-fit: cover; border-radius: 50%; flex-shrink: 0;">
                    <div class="brand__text" style="display: flex; flex-direction: column;">
                        <span class="brand__title">SDG Network Hub</span>
                        <span class="brand__subtitle">Partnering for SDG 17 through people-powered opportunities</span>
                    </div>
                </a>
                <nav>
                    <ul class="nav-list">
                        <li><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        @auth
                            <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                            @if (auth()->user()->isOrganization())
                                <li><a class="nav-link" href="{{ route('opportunities.manage') }}">My postings</a></li>
                            @else
                                <li><a class="nav-link" href="{{ route('applications.mine') }}">My applications</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn-secondary">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li><a class="btn-primary" href="{{ route('register') }}">Join the hub</a></li>
                        @endauth
                        <li>
                            <button type="button" class="theme-toggle" id="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">
                                <div class="theme-toggle__stars">
                                    <span class="theme-toggle__star"></span>
                                    <span class="theme-toggle__star"></span>
                                    <span class="theme-toggle__star"></span>
                                </div>
                                <div class="theme-toggle__thumb">
                                    <svg class="theme-toggle__icon theme-toggle__icon--sun" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                                    </svg>
                                    <svg class="theme-toggle__icon theme-toggle__icon--moon" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                                    </svg>
                                </div>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        @if (session('status'))
            <div class="page-content" style="margin-bottom: 0;">
                <div class="status-banner animate-fade-in-up">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <main class="page-content animate-fade-in-up">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <footer>
            &copy; {{ now()->year }} SDG Network Hub. Advancing Goal 17 partnerships worldwide.
        </footer>
    </div>
    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('theme-toggle');
            if (toggle) {
                toggle.addEventListener('click', function() {
                    // Add transition class for smooth animation
                    document.documentElement.classList.add('theme-transition');
                    
                    // Toggle dark class
                    document.documentElement.classList.toggle('dark');
                    
                    // Save preference
                    const isDark = document.documentElement.classList.contains('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    
                    // Remove transition class after animation completes
                    setTimeout(function() {
                        document.documentElement.classList.remove('theme-transition');
                    }, 400);
                });
            }
        });
    </script>
</body>
</html>
