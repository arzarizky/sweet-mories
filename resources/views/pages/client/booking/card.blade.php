<div class="row ps-3 pe-3">
    @forelse ($datas as $data)
        <div class="col-md-6 col-lg-4 mb-3">
            <div
                class="card border
                    @if ($data->status === 'PENDING') border-primary
                    @elseif ($data->status === 'ON PROCESS')
                        border-warning
                    @elseif ($data->status == 'DONE')
                        border-success
                    @else
                        border-dark @endif mb-3">
                <div class="card-header">
                    {{ $data->booking_date }} | {{ $data->booking_time }}
                    @if ($data->status === 'PENDING')
                        <span class="ms-2 badge rounded-pill bg-primary">{{ $data->status }}</span>
                    @elseif ($data->status === 'ON PROCESS')
                        <span class="ms-2 badge rounded-pill bg-warning">{{ $data->status }}</span>
                    @elseif ($data->status == 'DONE')
                        <span class="ms-2 badge rounded-pill bg-success">{{ $data->status }}</span>
                    @else
                        <span class="ms-2 badge rounded-pill bg-dark">{{ $data->status ?? 'NOT DEF' }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data->book_id ?? 'Data Tidak Ada' }}</h5>
                    <p class="card-text">
                    <ul class="pt-2">
                        @foreach ($data->productBookings as $product)
                            <li>
                                {{ $product->products->name ?? 'Data Tidak Ada' }} :
                                {{ $product->products->price ?? 'Data Tidak Ada' }} x
                                {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                            </li>
                        @endforeach
                    </ul>
                    <h5 class="card-title">Total Price : {{ $data->total_price }}</h5>

                    </p>
                    <a href="javascript:void(0)" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-danger text-center">
            <div class="card">
                @if (request()->input('search') === null)
                    <h5 class="mt-5 mb-5">{{$users->name}} Belum Pernah Booking 😢</h5>
                @else
                    <h5 class="mt-5 mb-5">Pesanan {{$users->name}} dengan {{request()->input('search')}} tidak ada</h5>
                @endif
            </div>
        </div>
    @endforelse
</div>
