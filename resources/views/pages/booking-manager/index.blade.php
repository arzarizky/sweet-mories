@extends('layouts.app', [
    'title' => 'Booking Manager',
])

@section('konten')
    {{-- search dan sort --}}
    @include('pages.booking-manager.search-sort-booking')
    {{-- search dan sort --}}


    {{-- data table user --}}
    @include('pages.booking-manager.table-booking')
    {{-- data table user --}}
@endsection
