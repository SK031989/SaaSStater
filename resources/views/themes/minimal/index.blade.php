@extends('themes.minimal.layouts.marketing')

@section('title', 'Minimal Home')

@section('content')
    <section class="py-5 my-lg-5 text-center">
        <div class="container py-5">
            <h1 class="display-3 fw-bold text-dark mb-3">Minimalist Light</h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 600px;">A clean, elegant light theme utilizing sharp modern borders directly under root resources.</p>
            <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">Register Now</a>
        </div>
    </section>
@endsection
