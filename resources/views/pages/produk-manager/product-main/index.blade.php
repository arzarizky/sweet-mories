@extends('layouts.app', [
    'title' => 'Product Manager',
])

@section('konten')
<div class="fitur-product-main">
    <div class="card p-3 mb-4 nav-sticky-top" style="z-index: 1075;">
        {{-- Nav --}}
        @include('pages.produk-manager.nav-product')
        {{-- Nav --}}

        {{-- search dan sort --}}
        @include('pages.produk-manager.product-main.search-sort')
        {{-- search dan sort --}}
    </div>

</div>


    {{-- data table user --}}
    @include('pages.produk-manager.product-main.table')
    {{-- data table user --}}
@endsection
