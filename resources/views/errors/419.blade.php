<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session Expired - SDG Network Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #111827 0%, #1e293b 50%, #0f172a 100%);
            color: #fff;
            padding: 1.5rem;
        }
        
        .error-container { text-align: center; max-width: 480px; }
        
        .error-icon {
            width: 88px;
            height: 88px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, rgba(147, 197, 253, 0.15), rgba(196, 181, 253, 0.15));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-icon svg {
            width: 44px;
            height: 44px;
            stroke: #93c5fd;
        }
        
        .error-code {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            background: linear-gradient(135deg, #93c5fd, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .error-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 1rem;
        }
        
        .error-message {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin: 0 0 2rem;
        }
        
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background: #fff;
            color: #111827;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -10px rgba(255, 255, 255, 0.3);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .countdown {
            margin-top: 2rem;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .countdown span {
            color: #93c5fd;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <!-- Clock icon from Heroicons -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <p class="error-code">419</p>
        <h1 class="error-title">Session Expired</h1>
        <p class="error-message">
            Your session has expired due to inactivity. This is a security measure to protect your account. 
            Please refresh the page or go back to continue.
        </p>
        <div class="error-actions">
            <a href="{{ url()->previous() }}" class="btn btn-primary" onclick="event.preventDefault(); window.location.reload();">
                Refresh Page
            </a>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                Back to Home
            </a>
        </div>
        <p class="countdown">
            Redirecting automatically in <span id="timer">5</span> seconds...
        </p>
    </div>
    
    <script>
        let seconds = 5;
        const timerElement = document.getElementById('timer');
        const countdown = setInterval(() => {
            seconds--;
            timerElement.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '{{ route("home") }}';
            }
        }, 1000);
    </script>
</body>
</html>
