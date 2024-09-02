<div class="row ps-3 pe-3">
    @forelse ($datas as $data)
        <div class="col-md-6 col-lg-4 mb-3">
            <div
                class="card border
                    @if ($data->status === 'PENDING') border-primary
                    @elseif ($data->status === 'CANCELLED')
                        border-warning
                    @elseif ($data->status === 'EXP')
                        border-warning
                    @elseif ($data->status == 'PAID')
                        border-success
                    @else
                        border-dark @endif mb-3">
                <div class="card-header">
                    {{ $data->booking_date }} | {{ $data->booking_time }}
                    @if ($data->status === 'PENDING')
                        <span class="ms-2 badge rounded-pill bg-primary">{{ $data->status }}</span>
                    @elseif ($data->status === 'CANCELLED')
                        <span class="ms-2 badge rounded-pill bg-warning">{{ $data->status }}</span>
                    @elseif ($data->status == 'PAID')
                        <span class="ms-2 badge rounded-pill bg-success">{{ $data->status }}</span>
                    @elseif ($data->status == 'EXP')
                        <span class="ms-2 badge rounded-pill bg-danger">{{ $data->status }}</span>
                    @else
                        <span class="ms-2 badge rounded-pill bg-dark">{{ $data->status ?? 'NOT DEF' }}</span>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $data->book_id ?? 'Data Tidak Ada' }}</h5>
                    <p class="card-text">
                        {{-- <ul class="pt-2">
                        @foreach ($data->productBookings as $product)
                            <li>
                                {{ $product->products->name ?? 'Data Tidak Ada' }} :
                                {{ $product->products->price ?? 'Data Tidak Ada' }} x
                                {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                            </li>
                        @endforeach
                    </ul> --}}
                    <h5 class="card-title">Total Price : {{ $data->amount }}</h5>

                    </p>
                    {{-- {{dd(route('payment', ['email' => $users->email] ))}} --}}
                    <form method="post" action="{{ route('payment', ['email' => $users->email]) }}">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $data->book_id }}">
                        <button type="submit"
                            class="btn
                            @if ($data->status === 'PENDING') btn-primary
                            @elseif ($data->status === 'CANCELLED')
                                btn-warning
                            @elseif ($data->status === 'EXP')
                                btn-warning
                            @elseif ($data->status == 'PAID')
                                btn-success
                            @else
                                btn-dark @endif
                        ">Buat
                            Invoice</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-danger text-center">
            <div class="card">
                @if (request()->input('search') === null)
                    <h5 class="mt-5 mb-5">{{ $users->name }} Belum Pernah Booking 😢</h5>
                @else
                    <h5 class="mt-5 mb-5">Pesanan {{ $users->name }} dengan {{ request()->input('search') }} tidak
                        ada</h5>
                @endif
            </div>
        </div>
    @endforelse
</div>
