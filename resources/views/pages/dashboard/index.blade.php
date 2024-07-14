@extends('layouts.app', [
    'title' => 'Dasboard',
])

@section('konten')
    <div class="row">
        {{-- hello card --}}
        <div class="col-lg-12 mb-4">
            @include('pages.dashboard.hello-card')
        </div>
        {{-- / hello card --}}

        {{-- total user --}}
        @include('pages.dashboard.total-user')
        {{-- / total user --}}

        {{-- growth sales yearly --}}
        {{-- <div class="col-12 col-lg-12 mb-4">
                @include('pages.dashboard.growth-sales-yearly-card')
            </div> --}}
        {{-- / growth sales yearly --}}

        {{-- progress sales --}}
        {{-- <div class="col-sm-12 col-lg-8">
                @include('pages.dashboard.progress-sales-card')
            </div> --}}
        {{-- / progress sales --}}

        {{-- top 5 product --}}
        {{-- <div class="col-md-12 col-lg-4 col-xl-4 mb-4">
                @include('pages.dashboard.top-product-card')
            </div> --}}
        {{-- / top 5 product --}}
    </div>
@endsection

@push('js-konten')
    <script src="{{ asset('template') }}/assets/js/dashboards-analytics.js"></script>
@endpush
