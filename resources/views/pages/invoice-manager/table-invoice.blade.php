@php
    $routeBook = route('booking-manager');
    $routePage = "&per_page=5&page=1";
    $routeBookSearch = "?search=";
    $urlBook = $routeBook . $routeBookSearch;
@endphp

<div class="card" style="border-top-left-radius: 0px;">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
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
                @forelse ($datas as $data)
                    <tr>
                        <td>
                            {{ $data->invoice_id ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            <a href="{{$urlBook . $data->book_id . $routePage}}" target="_blank">{{ $data->book_id ?? 'Data Tidak Ada' }}</a>
                        </td>
                        <td>
                            {{ $data->users->email ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            {{ $data->amount ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            @if ($data->status === 'PENDING')
                                <span class="badge rounded-pill bg-primary">{{ $data->status ?? "NOT DEF"}}</span>
                            @elseif ($data->status === 'CANCELLED')
                                <span class="badge rounded-pill bg-danger">{{ $data->status ?? "NOT DEF"}}</span>

                            @elseif ($data->status == 'PAID')
                                <span class="badge rounded-pill bg-success">{{ $data->status ?? "NOT DEF"}}</span>
                            @elseif ($data->status == 'EXP')
                                <span class="badge rounded-pill bg-warning">{{ $data->status ?? "NOT DEF"}}</span>
                            @else
                                <span class="badge rounded-pill bg-dark">{{ $data->status ?? "NOT DEF" }}</span>
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
