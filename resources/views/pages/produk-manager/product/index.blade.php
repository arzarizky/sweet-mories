@extends('layouts.app', [
    'title' => 'Invoice Manager',
])

@section('konten')
    {{-- Nav --}}
    @include('pages.produk-manager.nav-product')
    {{-- Nav --}}

    {{-- search dan sort --}}
    @include('pages.produk-manager.product.search-sort')
    {{-- search dan sort --}}


    {{-- data table user --}}
    @include('pages.produk-manager.product.table')
    {{-- data table user --}}
@endsection
