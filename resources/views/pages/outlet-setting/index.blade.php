@extends('layouts.app', [
    'title' => 'Invoice Manager',
])

@section('konten')
    {{-- search dan sort --}}
    @include('pages.outlet-setting.search-sort-invoice')
    {{-- search dan sort --}}


    {{-- data table user --}}
    @include('pages.outlet-setting.table')
    {{-- data table user --}}

    @include('pages.outlet-setting.add')
@endsection
