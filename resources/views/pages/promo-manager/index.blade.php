@extends('layouts.app', [
    'title' => 'Invoice Manager',
])

@section('konten')
    {{-- search dan sort --}}
    @include('pages.promo-manager.search-sort-invoice')
    {{-- search dan sort --}}


    {{-- data table user --}}
    @include('pages.promo-manager.table')
    {{-- data table user --}}

    @include('pages.promo-manager.add')
    @include('pages.promo-manager.edit')
@endsection
