<table>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>

    <tr>
        <td><strong>Export pada tanggal</strong></td>
        <td>{{ $exportedAt }}</td>
    </tr>
    <tr>
        <td><strong>Data yang di export</strong></td>
        <td>
            Mulai {{ $from }}
        </td>
        <td>
            Sampai {{ $to }}
        </td>
    </tr>
    <tr>
        <td><strong>Di Export Oleh</strong></td>
        <td>{{ $exportedBy }}</td>
    </tr>
    <tr></tr>

    <thead>
        <tr>
            <th>BOOK ID</th>
            <th>Alias Name</th>
            <th>Mail</th>
            <th>No Client</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Main Product</th>
            <th>Additional Product</th>
            <th>Background</th>
            <th>Promo</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
            <tr>
                <td>{{ $data->book_id ?? 'Data Tidak Ada' }}</td>
                <td>{{ $data->alias_name_booking ?? 'Data Tidak Ada' }}</td>
                <td>{{ $data->users->email ?? 'Data Tidak Ada' }}</td>
                <td>{{ $data->users->no_tlp ?? 'Data Tidak Ada' }}</td>
                <td>{{ $data->booking_date ?? 'Data Tidak Ada' }}</td>
                <td>{{ $data->booking_time ?? 'Data Tidak Ada' }}</td>
                <td>
                    @foreach ($data->productBookings as $product)
                        @if ($product->products->promo === 'true')
                            {{ $product->products->name ?? '-' }} {{ $product->products->type ?? '-' }} - {{ $product->products->price_promo ?? '0' }} x {{ $product->quantity_product }}<br>
                        @else
                            {{ $product->products->name ?? '-' }} {{ $product->products->type ?? '-' }} - {{ $product->products->price ?? '0' }} x {{ $product->quantity_product }}<br>
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($data->productAdditionalBookings as $additional)
                        {{ $additional->productsAdditional->name ?? '-' }} - {{ $additional->productsAdditional->price ?? '0' }} x {{ $additional->quantity_product }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($data->productBackgroundBookings as $background)
                        {{ $background->productsBackground->name ?? '-' }}<br>
                    @endforeach
                </td>
                <td>{{ $data->promo->code ?? '-' }}</td>
                <td>{{ $data->total_price }}</td>
                <td>{{ $data->status ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
