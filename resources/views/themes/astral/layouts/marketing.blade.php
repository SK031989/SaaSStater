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
            background: #090514;
            color: #fdf4ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-mkt {
            background: rgba(219, 70, 239, 0.05);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(219, 70, 239, 0.15);
        }
        .nav-link-mkt {
            color: #fdf4ff;
            font-weight: 500;
        }
        .nav-link-mkt:hover, .nav-link-mkt.active {
            color: #d946ef;
        }
        .mkt-card {
            background: rgba(22, 14, 42, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(219, 70, 239, 0.15);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(219, 70, 239, 0.05);
            transition: all 0.2s ease;
        }
        .mkt-card:hover {
            border-color: #d946ef;
            transform: scale(1.02);
        }
        .btn-mkt-primary {
            background: linear-gradient(135deg, #d946ef 0%, #6366f1 100%);
            border: none;
            color: #fff !important;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 1rem;
        }
        .btn-mkt-primary:hover {
            box-shadow: 0 0 20px rgba(219, 70, 239, 0.4);
        }
        .btn-mkt-outline {
            border: 1px solid rgba(219, 70, 239, 0.2);
            background: transparent;
            color: #fdf4ff;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 1rem;
        }
        .btn-mkt-outline:hover {
            border-color: #d946ef;
            background: rgba(219, 70, 239, 0.05);
        }
        footer {
            background: #160e2a;
            border-top: 1px solid rgba(219, 70, 239, 0.15);
            color: #c084fc;
        }
    </style>
</head>
<body>
    @include('themes.astral.layouts.header')

    <main class="flex-grow-1">@yield('content')</main>

    @include('themes.astral.layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
