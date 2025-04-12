@php
    $statuses = [
        'PENDING' => 'bg-primary',
        'ON PROCESS' => 'bg-warning',
        'DONE' => 'bg-success',
    ];

    $currentStatuses = (array) request()->input('status', []);
    $currentBgClass = $statuses[$currentStatuses[0] ?? ''] ?? 'bg-secondary';
@endphp

<form action="{{ url()->current() }}" method="GET" style="backdrop-filter: saturate(200%) blur(10px);">
    <div class="row">
        {{-- Input Pencarian --}}
        <div class="col-sm-4 col-lg-4 col-md-4 mb-4">
            <div class="card p-3">
                <div class="input-group">
                    <span class="input-group-text" style="cursor: pointer;" onclick="triggerSubmit();">
                        <i class="bx bx-search"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="Cari booking id atau email client"
                        name="search" value="{{ request('search') }}" aria-label="Search" onchange="triggerSubmit();">
                </div>
            </div>
        </div>

        {{-- Dropdown Status --}}
        <div class="col-sm-2 col-lg-2 col-md-2 mb-4">
            <div class="card p-3">
                <span class="badge p-3 rounded-pill {{ $currentBgClass }}" style="cursor: pointer;"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Status Booking {{ implode(', ', $currentStatuses) ?: 'ALL' }}
                </span>
                <ul class="dropdown-menu p-3">
                    @foreach ($statuses as $status => $class)
                        <li class="mb-2">
                            <label>
                                <input type="radio" name="status" value="{{ $status }}"
                                    onchange="triggerSubmit();"
                                    {{ in_array($status, $currentStatuses) ? 'checked' : '' }}>
                                <span class="badge rounded-pill {{ $class }}">{{ $status }}</span>
                            </label>
                        </li>
                    @endforeach
                    <li class="mt-2">
                        <label>
                            <input type="radio" name="status" value="ALL" onchange="triggerSubmit();"
                                {{ empty($currentStatuses) || in_array('ALL', $currentStatuses) ? 'checked' : '' }}>
                            <span class="badge rounded-pill bg-secondary">ALL</span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Input Tanggal --}}
        <div class="col-sm-4 col-lg-3 col-md-4 mb-4">
            <div class="card p-3">
                <div class="input-group">
                    <span class="input-group-text" style="cursor: pointer;" onclick="triggerSubmit();">
                        <i class="bx bx-calendar"></i>
                    </span>
                    <input type="search" class="form-control" placeholder="Cari tanggal" name="date" id="date"
                        value="{{ request('date') }}" autocomplete="off" onchange="triggerSubmit();">
                </div>
            </div>
        </div>

        {{-- Select Jumlah Per Halaman --}}
        <div class="col-sm-1 col-lg-1 col-md-1 mb-4">
            <div class="card p-3">
                <select id="sort-value" class="form-select" name="per_page" onchange="triggerSubmit();">
                    @foreach ([5, 10, 25, 50, 100] as $perPage)
                        <option value="{{ $perPage }}" @if (request('per_page', 5) == $perPage) selected @endif>
                            {{ $perPage }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-2 col-lg-2 col-md-2 mb-4">
            <div class="card p-2">
                <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#exportBooking">
                    <span class="icon-base bx bxs-file-export icon-sm me-2"></span>
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden Input untuk Pagination --}}
    <input type="hidden" name="page" value="{{ request('page', 1) }}">
    <button type="submit" id="submit-search" hidden></button>
</form>

{{-- JavaScript --}}
@push('js-konten')
    <script>
        // Fungsi untuk submit form secara umum
        function triggerSubmit() {
            document.getElementById('submit-search').click();
        }

        // Event Listener
        document.getElementById('sort-value').addEventListener('change', triggerSubmit);
        document.getElementById('date').addEventListener('change', triggerSubmit);

        // Datepicker
        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    </script>
@endpush
