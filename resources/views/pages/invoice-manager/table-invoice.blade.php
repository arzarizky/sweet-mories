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

<div class="modal fade" id="exportInvoice" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('export-invoice') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCloseOutletTitle">Export Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label">Nama Dokumen</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Contoh: Dokumen Invoice Bulan 04 Sampai 05 Tahun 2025">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="from">Mulai Tanggal</label>
                                <input type="date" class="form-control" name="from" id="from">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="to">Selesai Tanggal</label>
                                <input type="date" class="form-control" name="to" id="to">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group mb-3">
                                <label>
                                    <input type="checkbox" name="delete_after_export" value="1">
                                    Hapus data setelah export
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Export Excel</button>
                </div>
            </form>
        </div>
    </div>
</div>
