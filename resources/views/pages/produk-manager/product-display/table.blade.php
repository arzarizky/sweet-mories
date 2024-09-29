<div class="row">
    @forelse ($datas as $data)
        <div class="col-sm-6 mb-3">
            <div class="card">
                <img src="{{ $data->getPicProduct() }}" height="50%" class="card-img-top" alt="Picture Product">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->name }}</h5>
                    <p class="card-text">
                    <ul>
                        <li>
                            Type Product : {{ $data->stype }}
                        </li>
                        <li>
                            Sub Title : {{ $data->sub_title }}
                        </li>
                        <li>
                            Sub Title Promo : {{ $data->name ?? 'Tidak Promo' }}
                        </li>
                        <li>
                            Price Text : {{ $data->price_text }}
                        </li>
                        <li>
                            Price Promo Text : {{ $data->price_promo_text }}
                        </li>
                        <li>
                            Price : {{ $data->price }}
                        </li>
                        <li>
                            Price Promo : {{ $data->price_promo }}
                        </li>
                        <li>
                            T&C : {{ $data->tnc }}
                        </li>
                    </ul>
                    </p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    @empty
    @endforelse

</div>




{{-- <div class="d-flex justify-content-between" style="align-self: center;">
    <div class="ps-2" style="margin-top: 25px;" class="data-count">
        Menampilkan {{ $datas->count() }} data dari {{ $datas->total() }}
    </div>

    <div>
        {{ $datas->appends(['search' => $search, 'per_page' => $perPage])->links('layouts.pagination') }}

    </div>
</div> --}}
