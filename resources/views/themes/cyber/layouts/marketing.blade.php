<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marketing') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier Prime', monospace;
            background: #020617;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-mkt {
            background: #0b1329;
            border-bottom: 2px solid #06b6d4;
        }
        .nav-link-mkt {
            color: #e2e8f0;
            font-weight: 700;
        }
        .nav-link-mkt:hover, .nav-link-mkt.active {
            color: #06b6d4;
        }
        .mkt-card {
            background: #0b1329;
            border: 2px solid #1e293b;
            border-radius: 0;
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.1);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            border-color: #06b6d4;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.3);
        }
        .btn-mkt-primary {
            background: #06b6d4;
            border: none;
            color: #020617 !important;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 0;
        }
        .btn-mkt-primary:hover {
            background: #22d3ee;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.5);
        }
        .btn-mkt-outline {
            border: 2px solid #1e293b;
            background: transparent;
            color: #e2e8f0;
            font-weight: 700;
            padding: 0.75rem 1.75rem;
            border-radius: 0;
        }
        .btn-mkt-outline:hover {
            border-color: #06b6d4;
            color: #06b6d4;
        }
        footer {
            background: #020617;
            border-top: 2px solid #1e293b;
            color: #64748b;
        }
    </style>
</head>
<body>
    @include('themes.cyber.layouts.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.cyber.layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
