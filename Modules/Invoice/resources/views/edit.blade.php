@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Edit Invoice</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoice</a></li>
                    <li class="breadcrumb-item active">Edit #{{ $invoice->id }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST" enctype="multipart/form-data" id="edit-form">
                @csrf
                @method('PUT')
                @include('invoices::partials.form', ['model' => $invoice])
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update Invoice
                    </button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    @can('invoices.delete')
                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="ms-auto"
                          onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </form>
        </div>
    </div>

</div>
@endsection