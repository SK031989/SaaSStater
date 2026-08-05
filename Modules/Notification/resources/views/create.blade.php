@extends('dashboard::layouts.admin')

@section('title', 'Record Activity Log')

@section('content')
<div class="container-fluid max-w-4xl">
    <div class="d-flex items-center gap-3 mb-4">
        <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-light rounded-circle p-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h3 font-bold text-slate-900 dark:text-white mb-0">Record Activity Log</h1>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('notifications.store') }}" method="POST">
                @csrf
                @include('Notification::partials._form')

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('notifications.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-check-lg me-1"></i> Save Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
