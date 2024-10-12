@php
    $routeBook = route('booking-manager');
    $routePage = '&per_page=5&page=1';
    $routeBookSearch = '?search=';
    $urlBook = $routeBook . $routeBookSearch;
@endphp

<div class="card" style="border-top-left-radius: 0px;">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>CODE</th>
                    <th>DISCOUNT</th>
                    <th>DATE</th>
                    <th>USED</th>
                    <th>LIMIT</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>
                            {{ $data->name ?? 'Data Tidak Ada' }}
                        </td>
                        <td class="text-primary" style="cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#editPromo-{{ $data->id }}">
                            {{ $data->code ?? 'Data Tidak Ada' }}
                        </td>
                        <td>
                            @if ($data->model === 'NUMBER')
                                Rp. {{ $data->discount_value ?? 'Data Tidak Ada' }}
                            @else
                                {{ $data->discount_percentage ?? 'Data Tidak Ada' }}%
                            @endif
                        </td>
                        <td>
                            <ul>
                                <li>
                                    Mulai Promo : {{ $data->start_date }}
                                </li>
                                <li>
                                    Selesai Promo : {{ $data->end_date }}
                                </li>
                            </ul>
                        </td>
                        <td>
                            {{ $data->used_count }}
                        </td>
                        <td>
                            {{ $data->usage_limit }}
                        </td>
                        <td>
                            @if ($data->is_active === 'ENABLE')
                                <span style="cursor: pointer;" class="badge rounded-pill bg-success"
                                    data-bs-toggle="dropdown" aria-expanded="false">{{ $data->is_active }}</span>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form method="POST" action="{{ route('promo-update-status', $data->id) }}">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="is_active" value="DISABLE">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-danger">DISABLE</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @elseif ($data->is_active === 'DISABLE')
                                <span style="cursor: pointer;" class="badge rounded-pill bg-danger"
                                    data-bs-toggle="dropdown" aria-expanded="false">{{ $data->is_active }}</span>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form method="POST" action="{{ route('promo-update-status', $data->id) }}">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="is_active" value="ENABLE">
                                            <button class="dropdown-item" type="submit">
                                                <span class="badge rounded-pill bg-success">ENABLE</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <span class="badge rounded-pill bg-dark">{{ $data->is_active ?? 'NOT DEF' }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-danger text-center" style="border: none;">
                            @if (request()->input('search') === null)
                                <h5 class="mt-5 mb-5">Data {{ request()->input('search') }} Tidak Ada</h5>
                            @else
                                <h5 class="mt-5 mb-5">Data <span class="text-danger">{{ request()->input('search') }}</span> Tidak Ada</h5>
                            @endif
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
