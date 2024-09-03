@extends('layouts.app', [
    'title' => "Invoice ".$users->name,
])

@section('konten')
    <div class="row">
        <div class="col-md-12">
            @include('pages.client.nav')
            <div class="mb-4">
                {{-- {{dd($datas)}} --}}
                @include('pages.client.invoice.card')
            </div>
        </div>
    </div>
    @foreach ($datas as $data)
        @include("pages.client.invoice.modal-qris.bayar")
    @endforeach
@endsection
