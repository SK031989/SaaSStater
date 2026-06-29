<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marketing') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0b0f19;
            color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-mkt {
            background: rgba(99, 102, 241, 0.03);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .nav-link-mkt {
            color: #f3f4f6;
            font-weight: 500;
        }
        .nav-link-mkt:hover, .nav-link-mkt.active {
            color: #6366f1;
        }
        .mkt-card {
            background: rgba(31, 41, 55, 0.6);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            transform: translateY(-4px);
        }
        .mkt-glow {
            filter: blur(100px);
            background: linear-gradient(135deg, #6366f1, #a855f7);
            opacity: 0.15;
            position: absolute;
            z-index: -1;
            width: 300px;
            height: 300px;
            border-radius: 50%;
        }
        .btn-mkt-primary {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            border: none;
            color: #fff !important;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
        }
        .btn-mkt-primary:hover {
            box-shadow: 0 8px 20px -4px rgba(99, 102, 241, 0.4);
        }
        .btn-mkt-outline {
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: transparent;
            color: #f3f4f6;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
        }
        .btn-mkt-outline:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
        }
        footer {
            background: #111827;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="mkt-glow" style="top: 10%; left: -50px;"></div>
    
    @include('themes.obsidian.layouts.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.obsidian.layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
