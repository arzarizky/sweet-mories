<div class="row ps-3 pe-3">
    @forelse ($datas as $data)
        @php
            // dd($datas);
        @endphp
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
                    @if ($data->status === 'EXP')
                        <button type="button" class="btn btn-dark" disabled>
                            Booking EXP Tidak Bisa Melakukan Pembayaran
                        </button>
                    @elseif ($data->status === 'DONE')
                        @if ($data->invoice != null)
                            <a href="{{ $data->invoice->payment_link }}">
                                <button type="button" class="btn btn-warning">
                                    Cek Pembayaran
                                </button>
                            </a>
                        @else
                            <form method="post" action="{{ route('payment', ['email' => $users->email]) }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $data->book_id }}">
                                <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                            </form>
                        @endif
                    @elseif ($data->status === 'ON PROCESS')
                        @if ($data->invoice != null)
                            <a href="{{ $data->invoice->payment_link }}">
                                <button type="button" class="btn btn-warning">
                                    Cek Pembayaran
                                </button>
                            </a>
                        @else
                            <form method="post" action="{{ route('payment', ['email' => $users->email]) }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $data->book_id }}">
                                <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                            </form>
                        @endif
                    @elseif ($data->status === 'PAYMENT PROCESS')
                        @if ($data->invoice != null)
                            <a href="{{ $data->invoice->payment_link }}">
                                <button type="button" class="btn btn-warning">
                                    Cek Pembayaran
                                </button>
                            </a>
                        @else
                            <form method="post" action="{{ route('payment', ['email' => $users->email]) }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $data->book_id }}">
                                <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                            </form>
                        @endif
                    @elseif ($data->status === 'PENDING')
                        @if ($data->invoice != null)
                            <a href="{{ $data->invoice->payment_link }}">
                                <button type="button" class="btn btn-warning">
                                    Cek Pembayaran
                                </button>
                            </a>
                        @else
                            <form method="post" action="{{ route('payment', ['email' => $users->email]) }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $data->book_id }}">
                                <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                            </form>
                        @endif
                    @else
                        <button type="button" class="btn btn-dark" disabled>
                            Booking Status Tidak Terdefinisi
                        </button>
                    @endif

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

<div class="d-flex justify-content-between" style="align-self: center;">
    <div class="ps-2" style="margin-top: 25px;" class="data-count">
        Menampilkan {{ $datas->count() }} data dari {{ $datas->total() }}
    </div>

    <div>
        {{ $datas->links('layouts.pagination') }}

    </div>
</div>
