@php
    use Carbon\Carbon;
    $routeBook = route('booking-manager');
    $routePage = '&per_page=5&page=1';
    $routeBookSearch = '?search=';
    $urlBook = $routeBook . $routeBookSearch;
@endphp

<div class="card rounded-0">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>DATE</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $data->name ?? 'Data Tidak Ada' }}</td>
                        <td>
                            <a href="{{ route('get-update-setting-outlet', $data->id) }}">
                                <ul class="list-unstyled mb-0">
                                    <li>Mulai Tutup Outlet: {{ $data->start_day }} Pukul {{ $data->start_time }}</li>
                                    <li>Selesai Tutup Outlet: {{ $data->end_day }} Pukul {{ $data->end_time }}</li>
                                </ul>
                            </a>
                        </td>
                        <td>
                            @if (in_array($data->is_active, ['ENABLE', 'DISABLE']))
                                @php
                                    $isActive = $data->is_active === 'ENABLE' ? 'bg-success' : 'bg-danger';
                                    $toggleStatus = $data->is_active === 'ENABLE' ? 'DISABLE' : 'ENABLE';
                                    $toggleBadge = $data->is_active === 'ENABLE' ? 'bg-danger' : 'bg-success';
                                @endphp

                                <div class="dropdown">
                                    <span class="badge rounded-pill {{ $isActive }}" data-bs-toggle="dropdown" style="cursor: pointer;">
                                        {{ $data->is_active }}
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form method="POST" action="{{ route('setting-outlet-status', $data->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="name" value="{{ $data->name ?? 'Data Tidak Ada' }}">
                                                <input type="hidden" name="is_active" value="{{ $toggleStatus }}">
                                                <button class="dropdown-item" type="submit">
                                                    <span class="badge rounded-pill {{ $toggleBadge }}">{{ $toggleStatus }}</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <span class="badge rounded-pill bg-dark">NOT DEF</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-danger">
                            <h5 class="my-5">
                                Data
                                @if (request()->input('search'))
                                    <span class="text-danger">{{ request()->input('search') }}</span>
                                @endif
                                Tidak Ada
                            </h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between" style="align-self: center;">
    <div class="ps-2" style="margin-top: 25px;" class="data-count">
        Menampilkan {{ $datas->count() }} dari {{ $datas->total() }} data
    </div>

    <div>
        {{ $datas->appends(['search' => $search, 'per_page' => $perPage])->links('layouts.pagination') }}

    </div>
</div>
