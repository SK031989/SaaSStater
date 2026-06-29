@extends('layouts.app')

@section('title', 'Invoice — List')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">{{ __('Invoice') }}</h1>
            <p class="text-muted mb-0 small">Manage all Invoice records</p>
        </div>
        @can('invoices.create')
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Invoice
        </a>
        @endcan
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filters --}}
    @include('invoices::partials.filters')

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @include('invoices::partials.table', ['invoices' => $invoices])
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }} of {{ $invoices->total() }} records
        </small>
        {{ $invoices->withQueryString()->links() }}
    </div>

</div>
@endsection