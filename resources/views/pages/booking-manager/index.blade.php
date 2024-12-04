@extends('layouts.app', [
    'title' => 'Booking Manager',
])

@section('konten')
    <div class="fitur-product-main">
        <div class="nav-sticky-top" style="z-index: 1075;">
            {{-- search dan sort --}}
            @include('pages.booking-manager.search-sort-booking')
            {{-- search dan sort --}}
        </div>
    </div>

    {{-- data table user --}}
    @include('pages.booking-manager.table-booking')
    {{-- data table user --}}
@endsection
