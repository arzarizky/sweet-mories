<div class="card" style="border-top-left-radius: 0px;">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-center">
                    <th>BOOK ID</th>
                    <th>Mail</th>
                    <th>Booking Detail</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>
                            {{ $data->book_id ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            {{ $data->users->email ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            Book Schedule : {{ $data->booking_date }} | {{ $data->booking_time }}
                            <ul class="pt-2">
                                @foreach ($data->productBookings as $product)
                                    <li>
                                        {{ $product->products->name ?? 'Data Tidak Ada' }} :
                                        {{ $product->products->price ?? 'Data Tidak Ada' }} x
                                        {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                                    </li>
                                @endforeach
                            </ul>
                            Total Price : {{ $data->total_price }}
                        </td>
                        <td>
                            @if ($data->status === 'PENDING')
                                <span style="cursor: pointer;" class="badge rounded-pill bg-primary"
                                    data-bs-toggle="dropdown" aria-expanded="false">{{ $data->status }}</span>
                                <ul class="dropdown-menu" style="">
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="PENDING">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-primary">PENDING</span>
                                            </button>
                                        </form>

                                    </li>
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="ON PROCESS">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-warning">ON PROCESS</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="DONE">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-success">DONE</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @elseif ($data->status === 'ON PROCESS')
                                <span style="cursor: pointer;" class="badge rounded-pill bg-warning"
                                    data-bs-toggle="dropdown" aria-expanded="false">{{ $data->status }}</span>
                                <ul class="dropdown-menu" style="">
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="PENDING">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-primary">PENDING</span>
                                            </button>
                                        </form>

                                    </li>
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="ON PROCESS">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-warning">ON PROCESS</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="DONE">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-success">DONE</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @elseif ($data->status == 'DONE')
                                <span style="cursor: pointer;" class="badge rounded-pill bg-success"
                                    data-bs-toggle="dropdown" aria-expanded="false">{{ $data->status }}</span>
                                <ul class="dropdown-menu" style="">
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="PENDING">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-primary">PENDING</span>
                                            </button>
                                        </form>

                                    </li>
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="ON PROCESS">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-warning">ON PROCESS</span>
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form method="POST"
                                            action="{{ route('booking-manager-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="DONE">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-success">DONE</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <span class="badge rounded-pill bg-dark">{{ $data->status ?? 'NOT DEF' }}</span>
                            @endif


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-danger text-center" style="border: none;">
                            <h5 class="mt-5 mb-5">Data {{ request()->input('search') }} Tidak Ada</h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between" style="align-self: center;">
    <div class="ps-2" style="margin-top: 25px;" class="data-count">
        Menampilkan {{ $datas->count() }} data dari {{ $datas->total() }}
    </div>

    <div>
        {{ $datas->appends(['search' => $search, 'per_page' => $perPage])->links('layouts.pagination') }}

    </div>
</div>
