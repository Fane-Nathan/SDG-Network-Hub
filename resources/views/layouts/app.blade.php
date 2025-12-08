<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SDG Network Hub') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <div class="site-navbar">
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand__title">SDG Network Hub</span>
                    <span class="brand__subtitle">Partnering for SDG 17 through people-powered opportunities</span>
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
</body>
</html>
