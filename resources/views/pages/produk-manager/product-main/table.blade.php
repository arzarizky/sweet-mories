<div class="row">
    @forelse ($datas as $data)
        <div class="col-sm-6 mb-3">
            <div class="card">
                <img src="{{ $data->getPicProduct() }}" height="50%" class="card-img-top" alt="Picture Product">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $data->name }} |
                        @if ($data->status == 'DISABLE')
                            <span style="cursor: pointer;" class="badge rounded-pill bg-danger" data-bs-toggle="dropdown"
                                aria-expanded="false">{{ $data->status }}</span>
                            <ul class="dropdown-menu" style="">
                                <li>
                                    <form method="POST"
                                        action="{{ route('booking-manager-update-status', $data->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="DISABLE">
                                        <button class="dropdown-item" type="submit">
                                            <span class="badge rounded-pill bg-danger">DISABLE</span>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST"
                                        action="{{ route('booking-manager-update-status', $data->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="ENABLE">
                                        <button class="dropdown-item" type="submit">
                                            <span class="badge rounded-pill bg-success">ENABLE</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <span style="cursor: pointer;" class="badge rounded-pill bg-success"
                                data-bs-toggle="dropdown" aria-expanded="false">{{ $data->status }}</span>
                            <ul class="dropdown-menu" style="">
                                <li>
                                    <form method="POST"
                                        action="{{ route('booking-manager-update-status', $data->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="ENABLE">
                                        <button class="dropdown-item" type="submit">
                                            <span class="badge rounded-pill bg-success">ENABLE</span>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST"
                                        action="{{ route('booking-manager-update-status', $data->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="DISABLE">
                                        <button class="dropdown-item" type="submit">
                                            <span class="badge rounded-pill bg-danger">DISABLE</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        @endif
                    </h5>

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


                    <a href="#" class="btn btn-primary">Edit</a>
                    <a href="#" class="btn btn-primary">Update</a>
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
