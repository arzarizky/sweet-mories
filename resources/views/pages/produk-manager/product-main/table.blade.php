@push('css-konten')
    <style>
        #table-product-main .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
@endpush

<div class="row">
    @forelse ($datas as $data)
        <div class="col-sm-6 mb-3">
            <div id="table-product-main" class="card">
                <!-- Image -->
                <img style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#viewPicture-{{ $data->id }}"
                    src="{{ $data->getPicProduct() }}" class="card-img-top" alt="Picture Product">

                <!-- Card Body -->
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        <!-- Display Name and Type -->
                        <span>
                            {{ $data->name ?? 'Tidak Ada Data' }} {{ $data->type ?? 'Tidak Ada Data' }}
                        </span>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Status Badge and Dropdown -->
                            <div class="dropdown me-2">
                                <span style="cursor: pointer;"
                                    class="badge rounded-pill {{ $data->status == 'DISABLE' ? 'bg-danger' : 'bg-success' }}"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $data->status }}
                                </span>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form method="POST"
                                            action="{{ route('product-manager-product-main-update-status', $data->id) }}">
                                            @csrf
                                            <input type="hidden" name="status"
                                                value="{{ $data->status == 'DISABLE' ? 'ENABLE' : 'DISABLE' }}">
                                            <button class="dropdown-item" type="submit">
                                                <span
                                                    class="badge rounded-pill {{ $data->status == 'DISABLE' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $data->status == 'DISABLE' ? 'ENABLE' : 'DISABLE' }}
                                                </span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            @if ($data->promo === 'true')
                                <span class="badge rounded-pill bg-warning">
                                    PROMO
                                </span>
                            @endif
                        </div>

                    </h5>

                    <!-- Card Text and Product Details -->
                    <p class="card-text">
                    <ul>
                        <li>Type Product: {{ $data->type ?? 'Tidak Ada Data' }}</li>
                        <li>Sub Title: {{ $data->sub_title ?? 'Tidak Ada Data' }}</li>
                        <li>Sub Title Promo: {{ $data->sub_title_promo ?? 'Tidak Promo' }}</li>
                        <li>Price Text: {{ $data->price_text ?? 'Tidak Ada Data' }}</li>
                        <li>Price Promo Text: {{ $data->price_promo_text ?? 'Tidak Ada Data' }}</li>
                        <li>Price: {{ $data->price ?? 'Tidak Ada Data' }}</li>
                        <li>Price Promo: {{ $data->price_promo ?? 'Tidak Ada Data' }}</li>

                        <li class="collapse" id="collapseExample-{{ $data->id }}" style="">
                            T&C:
                            @if (!empty($data->tnc))
                                <ol>
                                    @foreach (json_decode($data->tnc, true) as $term)
                                        <li>{{ $term ?? 'Tidak Ada Data' }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <span>Tidak Ada Data</span>
                            @endif
                        </li>
                    </ul>
                    </p>

                    <!-- Edit and Update Buttons -->
                    <button class="btn btn-info collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample-{{ $data->id }}" aria-expanded="false"
                        aria-controls="collapseExample-{{ $data->id }}" onclick="toggleTnC(this)">
                        SHOW T&C
                    </button>
                    <a href="{{ route('product-manager-product-main-edit', $data->id) }}"
                        class="btn btn-primary">EDIT</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
           <div class="card p-3 text-center">
            <h4 class="m-0">
                Nama Product <span class="text-danger">{{ request()->input('search') }}</span> Tidak Ada
            </h4>
           </div>
        </div>
    @endforelse

    <div class="d-flex justify-content-between" style="align-self: center;">
        <div class="ps-2" style="margin-top: 25px;" class="data-count">
            Menampilkan {{ $datas->count() }} data dari {{ $datas->total() }}
        </div>

        <div>
            {{ $datas->appends(['search' => $search, 'per_page' => $perPage,])->links('layouts.pagination') }}

        </div>
    </div>
</div>

@push('js-konten')
    <script>
        function toggleTnC(button) {
            const isExpanded = button.getAttribute('aria-expanded') === 'false';
            button.textContent = isExpanded ? 'Show T&C' : 'CLOSE T&C';
        }
    </script>
@endpush
