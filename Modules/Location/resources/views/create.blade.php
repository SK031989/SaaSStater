@extends('dashboard::layouts.admin')

@section('title', 'Add New Location')

@section('content')
<div class="container-fluid py-4">
    <div class="max-w-4xl mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">Create Location</h1>
                <p class="text-sm text-slate-500 mb-0">Add a new physical office or regional address hub.</p>
            </div>
            <a href="{{ route('locations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back to Locations
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4">
            <form action="{{ route('locations.store') }}" method="POST">
                @csrf
                @include('locations::partials._form')

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('locations.index') }}" class="btn btn-light dark:bg-slate-800 dark:text-slate-300 rounded-3 px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
