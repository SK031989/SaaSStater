@extends('themes.obsidian.layouts.marketing')

@section('title', 'Obsidian Dark Home')

@section('content')
    <section class="py-5 my-lg-5 text-center">
        <div class="container py-5">
            <h1 class="display-3 fw-bold text-white mb-3">Obsidian Cosmic Dark</h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 600px;">A sleek, violet cosmic background theme designed directly under root resource subfolders.</p>
            <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">Explore Obsidian Starter</a>
        </div>
    </section>
@endsection
