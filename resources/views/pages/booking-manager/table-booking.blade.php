<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-center">
                    <th>BOOK ID</th>
                    <th>Alias Name</th>
                    <th>Mail</th>
                    <th>No Client</th>
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
                            {{ $data->alias_name_booking ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            {{ $data->users->email ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            <a href="https://wa.me/{{ $data->users->no_tlp ?? 'Data Tidak Ada' }}"
                                target="_balnk">{{ $data->users->no_tlp ?? 'Data Tidak Ada' }}</a>
                        </td>
                        <td>
                            Book Schedule : {{ $data->booking_date }} | {{ $data->booking_time }}
                            <a href="{{ route('booking-manager-reschedule', $data->id) }}"> <i
                                    class='menu-icon tf-icons bx bx-time-five'></i></a>
                            <ul class="pt-2">
                                @foreach ($data->productBookings as $product)
                                    @if ($product->products->promo === 'true')
                                        <li class="text-warning">
                                            {{ $product->products->name ?? 'Data Tidak Ada' }}
                                            {{ $product->products->type ?? 'Data Tidak Ada' }} :
                                            {{ $product->products->price_promo ?? 'Data Tidak Ada' }} x
                                            {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                                        </li>
                                    @else
                                        <li>
                                            {{ $product->products->name ?? 'Data Tidak Ada' }}
                                            {{ $product->products->type ?? 'Data Tidak Ada' }} :
                                            {{ $product->products->price ?? 'Data Tidak Ada' }} x
                                            {{ $product->quantity_product ?? 'Data Tidak Ada' }}
                                        </li>
                                    @endif
                                @endforeach



                                @foreach ($data->productAdditionalBookings as $additional)
                                    <li>
                                        {{ $additional->productsAdditional->name ?? 'Data Tidak Ada' }} :
                                        {{ $additional->productsAdditional->price ?? 'Data Tidak Ada' }} x
                                        {{ $additional->quantity_product ?? 'Data Tidak Ada' }}
                                    </li>
                                @endforeach

                                @foreach ($data->productBackgroundBookings as $background)
                                    <li>
                                        Background : {{ $background->productsBackground->name ?? 'Data Tidak Ada' }}
                                    </li>
                                @endforeach

                                @if ($data->promo != null)
                                    <li>
                                        Promo : {{ $data->promo->code }}
                                    </li>
                                @endif

                            </ul>
                            Booking Dibuat Di Tanggal : {{ $data->created_at }}
                            <br>
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
                        <td colspan="6" class="text-center" style="border: none;">
                            @php
                                $search = request()->input('search', 'DATA');
                                $date = request()->input('date');
                                $statuses = (array) request()->input('status', []);
                                $statusMessage = !empty($statuses) ? 'DENGAN STATUS ' . implode(', ', $statuses) : '';

                                if ($date) {
                                    $message = "$search PADA TANGGAL $date $statusMessage TIDAK ADA";
                                } elseif (!empty($statuses)) {
                                    $message = "$search $statusMessage TIDAK ADA";
                                } else {
                                    $message = "$search TIDAK ADA";
                                }
                            @endphp

                            <h5 class="mt-5 mb-5 text-center text-danger">DATA {{ $message }}</h5>
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
        {{ $datas->appends(['search' => $search, 'per_page' => $perPage, 'date' => $date, 'status' => $status])->links('layouts.pagination') }}
    </div>
</div>
