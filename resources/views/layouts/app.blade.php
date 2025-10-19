<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SDG Network Hub') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --brand-primary: #4c6fff;
            --brand-secondary: #9d4bff;
            --brand-tertiary: #22d3ee;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --surface: rgba(255, 255, 255, 0.82);
            --surface-strong: rgba(255, 255, 255, 0.94);
            --border-soft: rgba(148, 163, 184, 0.18);
            --shadow-lg: 0 25px 50px -12px rgba(15, 23, 42, 0.2);
            --shadow-md: 0 15px 35px -15px rgba(15, 23, 42, 0.25);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top left, #edf2ff 0%, #f9fbff 55%, #fbfcff 100%);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(650px circle at 0% -20%, rgba(76, 111, 255, 0.25), transparent 55%),
                        radial-gradient(480px circle at 85% 0%, rgba(157, 75, 255, 0.18), transparent 60%),
                        radial-gradient(400px circle at 15% 85%, rgba(34, 211, 238, 0.15), transparent 60%);
            filter: blur(0px);
            z-index: 0;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page-shell {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(20px);
            background: rgba(8, 47, 73, 0.12);
        }

        .site-navbar {
            max-width: 1180px;
            margin: 0 auto;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .brand__title {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            color: #0b1b3a;
        }

        .brand__subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .nav-link {
            padding: 0.55rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
            color: #0b1b3a;
        }

        .nav-link:hover,
        .nav-link:focus-visible {
            background: rgba(255, 255, 255, 0.8);
            color: var(--brand-primary);
            transform: translateY(-1px);
        }

        .btn-primary,
        .btn-secondary,
        .btn-ghost {
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.65rem 1.4rem;
            border: none;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            color: #fff;
            box-shadow: 0 15px 30px -12px rgba(76, 111, 255, 0.5);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 38px -18px rgba(76, 111, 255, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--brand-primary);
            border: 1px solid rgba(76, 111, 255, 0.35);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            background: #fff;
            box-shadow: 0 15px 25px -15px rgba(76, 111, 255, 0.45);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
        }

        .page-content {
            max-width: 1180px;
            width: 100%;
            margin: 2.5rem auto 0;
            padding: 0 1.5rem 3rem;
            flex: 1 0 auto;
        }

        .status-banner {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #047857;
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            backdrop-filter: blur(16px);
            box-shadow: 0 20px 45px -25px rgba(16, 185, 129, 0.4);
        }

        .card {
            background: var(--surface);
            border-radius: 1.5rem;
            padding: clamp(1.5rem, 2.5vw, 2.25rem);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-soft);
            backdrop-filter: blur(22px);
        }

        .card--elevated {
            background: var(--surface-strong);
            box-shadow: var(--shadow-lg);
        }

        .headline {
            font-size: clamp(2rem, 5vw, 2.8rem);
            font-weight: 700;
            letter-spacing: -0.01em;
            color: #081534;
        }

        .muted-copy {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
        }

        label {
            display: block;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.9rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background: rgba(255, 255, 255, 0.92);
            font-size: 0.95rem;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: rgba(76, 111, 255, 0.6);
            box-shadow: 0 0 0 4px rgba(76, 111, 255, 0.12);
        }

        textarea {
            resize: vertical;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 0.35rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--brand-primary);
            background: rgba(76, 111, 255, 0.12);
        }

        footer {
            max-width: 1180px;
            margin: 0 auto 2.5rem auto;
            padding: 0 1.5rem;
            color: rgba(15, 23, 42, 0.55);
            font-size: 0.9rem;
            text-align: center;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .site-navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            nav ul {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .page-content {
                margin-top: 2rem;
                padding: 0 1rem 2.5rem;
            }
        }
    </style>
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
                    <ul>
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
                <div class="status-banner card card--elevated">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <main class="page-content">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <footer>
            &copy; {{ now()->year }} SDG Network Hub. Advancing Goal 17 partnerships worldwide.
        </footer>
    </div>
</body>
</html>
