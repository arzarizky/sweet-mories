
@php
    $routeBook = route('booking-manager');
    $routePage = "&per_page=5&page=1";
    $routeBookSearch = "?search=";
    $urlBook = $routeBook . $routeBookSearch;
@endphp

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
        <tr class="text-center">
            <th>INVOICE ID</th>
            <th>BOOK ID</th>
            <th>Mail</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
            <tr>
                <td>
                    {{ $data->invoice_id ?? 'Data Tidak Ada' }}
                </td>
                <td>
                    <a href="{{ $urlBook . $data->book_id . $routePage }}"
                        target="_blank">{{ $data->book_id ?? 'Data Tidak Ada' }}</a>
                </td>
                <td>
                    {{ $data->users->email ?? 'Data Tidak Ada' }}
                </td>
                <td>
                    {{ $data->amount ?? 'Data Tidak Ada' }}
                </td>
                <td>
                    @if ($data->status === 'PENDING')
                        <span class="badge rounded-pill bg-primary">{{ $data->status ?? 'NOT DEF' }}</span>
                    @elseif ($data->status === 'CANCELLED')
                        <span class="badge rounded-pill bg-danger">{{ $data->status ?? 'NOT DEF' }}</span>
                    @elseif ($data->status == 'PAID')
                        <span class="badge rounded-pill bg-success">{{ $data->status ?? 'NOT DEF' }}</span>
                    @elseif ($data->status == 'EXP')
                        <span class="badge rounded-pill bg-warning">{{ $data->status ?? 'NOT DEF' }}</span>
                    @else
                        <span class="badge rounded-pill bg-dark">{{ $data->status ?? 'NOT DEF' }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
