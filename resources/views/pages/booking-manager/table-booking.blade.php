<div class="card" style="border-top-left-radius: 0px;">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Mail</th>
                    <th>No Tlp</th>
                    <th>Booking Product</th>
                    <th>Total Price</th>
                    <th>Book Date</th>
                    <th>Book Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>
                            {{ $data->book_id }}
                        </td>
                        <td>
                            {{ $data->userBook->name }}
                        </td>
                        <td>
                            {{ $data->userBook->email }}
                        </td>
                        <td>
                            <ul>
                                @foreach ($data->productDetail as $product)
                                    <li>
                                        {{ $product->name }} x {{ $data->quantity_product }}
                                    </li>
                                @endforeach

                            </ul>
                        </td>
                        <td>
                            {{ $data->bookingDetail->total_price }}
                        </td>
                        <td>
                            {{ $data->bookingDetail->booking_date }}
                        </td>
                        <td>
                            {{ $data->bookingDetail->booking_time }}
                        </td>
                        <td>
                            {{ $data->bookingDetail->status }}
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
        {{ $users->appends(['search' => $search, 'per_page' => $perPage])->links('layouts.pagination') }}

    </div>
</div>
