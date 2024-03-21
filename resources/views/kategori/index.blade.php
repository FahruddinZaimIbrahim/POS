@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Manage Kategori</div>
        <div class="card-body">
            {{$dataTable->table()}}
            <!-- Add button to redirect to create category page -->
            <a href="{{ url('/kategori/create') }}" class="btn btn-primary">Add</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}    
@endpush
