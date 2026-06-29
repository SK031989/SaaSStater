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
            background: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-mkt {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .nav-link-mkt {
            color: #0f172a;
            font-weight: 500;
        }
        .nav-link-mkt:hover, .nav-link-mkt.active {
            color: #3b82f6;
        }
        .mkt-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
        }
        .btn-mkt-primary {
            background: #0f172a;
            border: none;
            color: #ffffff !important;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
        }
        .btn-mkt-primary:hover {
            background: #1e293b;
        }
        .btn-mkt-outline {
            border: 1px solid #e2e8f0;
            background: transparent;
            color: #0f172a;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
        }
        .btn-mkt-outline:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            color: #475569;
        }
    </style>
</head>
<body>
    @include('themes.minimal.layouts.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.minimal.layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
