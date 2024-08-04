@extends('layouts.app', [
    'title' => $users->name,
])

@section('konten')
    <div class="row">
        <div class="col-md-12">
            @include('pages.client.nav')
            <div class="card
                mb-4">
                @include('pages.client.account.card')
            </div>
        </div>
    </div>
@endsection
