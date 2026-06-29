@extends('themes.astral.layouts.marketing')

@section('title', 'Astral Home')

@section('content')
    <section class="py-5 my-lg-5 text-center">
        <div class="container py-5">
            <h1 class="display-3 fw-bold text-white mb-3">Astral Nebula Portal</h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 600px;">A high-end glassmorphism template utilizing frosted components directly under resource folder structures.</p>
            <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">Register in Portal</a>
        </div>
    </section>
@endsection
