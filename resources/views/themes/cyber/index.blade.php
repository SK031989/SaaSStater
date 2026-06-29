@extends('themes.cyber.layouts.marketing')

@section('title', 'Cyber Home')

@section('content')
    <section class="py-5 my-lg-5 text-center">
        <div class="container py-5">
            <h1 class="display-3 fw-bold text-info mb-3">> SYSTEM_LOADED_OK</h1>
            <p class="lead text-muted mx-auto mb-5" style="max-width: 600px;">Welcome to the neon terminal node. Theme resolved dynamically via root resource folders.</p>
            <a href="{{ route('auth.register') }}" class="btn btn-mkt-primary px-4 py-3">> JOIN_TRIAL</a>
        </div>
    </section>
@endsection
