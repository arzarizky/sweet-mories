@extends('layouts.app', [
    'title' => 'Product Background',
])

@section('konten')
<div class="fitur-product-main">
    <div class="card p-3 mb-4 nav-sticky-top" style="z-index: 1075;">
        {{-- Nav --}}
        @include('pages.produk-manager.nav-product')
        {{-- Nav --}}

        {{-- search dan sort --}}
        @include('pages.produk-manager.product-background.search-sort')
        {{-- search dan sort --}}
    </div>

</div>


    {{-- data table user --}}
    @include('pages.produk-manager.product-background.table')
    {{-- data table user --}}

    @include("pages.produk-manager.product-background.view-picture")
@endsection
