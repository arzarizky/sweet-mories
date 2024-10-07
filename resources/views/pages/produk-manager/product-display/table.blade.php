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
            <div class="card p-3">
                <div id="table-product-main" class="card">
                    <!-- Image -->
                    <img style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#viewPicture-{{ $data->id }}"
                        src="{{ $data->getPicProduct($data->products->picture) }}" class="card-img-top"
                        alt="Picture Product">

                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <!-- Display Name and Type -->
                            <span>
                                {{ $data->name ?? 'Tidak Ada Data' }}
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
                                                action="{{ route('product-manager-product-display-update-status', $data->id) }}">
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

                                @if ($data->products->promo === 'true')
                                    <span class="badge rounded-pill bg-warning">
                                        PROMO
                                    </span>
                                @endif
                            </div>
                        </h5>

                        <hr>

                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-product-{{ $data->id }}"
                                    aria-controls="navs-pills-top-product-{{ $data->id }}"
                                    aria-selected="true">Product</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-additional-{{ $data->id }}"
                                    aria-controls="navs-pills-top-additional-{{ $data->id }}" aria-selected="false"
                                    tabindex="-1">Additional</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-background-{{ $data->id }}"
                                    aria-controls="navs-pills-top-background-{{ $data->id }}" aria-selected="false"
                                    tabindex="-1">Background</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('product-manager-product-display-edit', $data->id) }}">
                                    <button type="button" class="nav-link">Edit</button>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-pills-top-product-{{ $data->id }}"
                            role="tabpanel">
                            <h3>Product</h3>
                            <p class="card-text">
                            <ul>
                                <li>Name Product: {{ $data->products->name ?? 'Tidak Ada Data' }}</li>
                                <li>Type Product: {{ $data->products->type ?? 'Tidak Ada Data' }}</li>
                                <li>Sub Title: {{ $data->products->sub_title ?? 'Tidak Ada Data' }}</li>
                                <li>Sub Title Promo: {{ $data->products->sub_title_promo ?? 'Tidak Promo' }}</li>
                                <li>Price Text: {{ $data->products->price_text ?? 'Tidak Ada Data' }}</li>
                                <li>Price Promo Text: {{ $data->products->price_promo_text ?? 'Tidak Promo' }}</li>
                                <li>Price: {{ $data->products->price ?? 'Tidak Ada Data' }}</li>
                                <li>Price Promo: {{ $data->products->price_promo ?? 'Tidak Promo' }}</li>
                                <li class="collapse" id="collapseTNC-{{ $data->id }}" style="">
                                    T&C:
                                    @if (!empty($data->products->tnc))
                                        <ol>
                                            @foreach (json_decode($data->products->tnc, true) as $term)
                                                <li>{{ $term ?? 'Tidak Ada Data' }}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <span>Tidak Ada Data</span>
                                    @endif
                                </li>
                            </ul>
                            </p>

                            <button class="btn btn-info collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTNC-{{ $data->id }}" aria-expanded="false"
                                aria-controls="collapseTNC-{{ $data->id }}" onclick="toggleTnC(this)">
                                SHOW T&C
                            </button>

                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-additional-{{ $data->id }}" role="tabpanel">
                            @foreach ($data->additionalProducts as $additional)
                                <div class="card mb-3">
                                    <div class="d-flex">
                                        <div style="width: 50%;">
                                            <img class="card-img card-img-left"
                                                src="{{ $additional->getPicProductAdditional() }}" alt="Card image"
                                                style="width: 100%; height: auto;">
                                        </div>
                                        <div class="flex-grow-1 ms-3 d-flex flex-column justify-content-center">
                                            <p class="card-text m-0">
                                                {{ $additional->name }}
                                            </p>
                                            <p class="card-text m-0">
                                                {{ $additional->price_text }}
                                            </p>
                                            <p class="card-text m-0">
                                                {{ $additional->price }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-background-{{ $data->id }}" role="tabpanel">
                            <div class="row">
                                @foreach ($data->backgroundsProducts as $background)
                                    <div class="col-4">
                                        <div class="card p-2">
                                            <img class="rounded" src="{{ $background->getPicProductBackground() }}"
                                                alt="Card image" style="width: 100%; height: auto;">
                                            <p class="text-center mt-2 mb-0">
                                                {{ $background->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card p-3 text-center">
                @if (request()->input('search') != null)
                    <h4 class="m-0">
                        Nama Product Display <span class="text-danger">{{ request()->input('search') }}</span> Tidak Ada
                    </h4>
                @else
                    <h4 class="m-0">
                        Belum Ada Display
                    </h4>
                @endif
            </div>
        </div>
    @endforelse

    <div class="d-flex justify-content-between" style="align-self: center;">
        <div class="ps-2" style="margin-top: 25px;" class="data-count">
            Menampilkan {{ $datas->count() }} data dari {{ $datas->total() }}
        </div>

        <div>
            {{ $datas->appends(['search' => $search, 'per_page' => $perPage])->links('layouts.pagination') }}

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
