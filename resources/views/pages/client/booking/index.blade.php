@extends('layouts.app', [
    'title' => "Booking ".$users->name,
])

@section('konten')
    <div class="row">
        <div class="col-md-12">
            @include('pages.client.nav')
            <div class="mb-4">
                {{-- {{dd($datas)}} --}}
                @include('pages.client.booking.card')
            </div>
        </div>
    </div>
@endsection
