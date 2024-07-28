@extends('layouts.app', [
    'title' => 'Invoice Manager',
])

@section('konten')
    {{-- search dan sort --}}
    @include('pages.invoice-manager.search-sort-invoice')
    {{-- search dan sort --}}


    {{-- data table user --}}
    @include('pages.invoice-manager.table-invoice')
    {{-- data table user --}}
@endsection
