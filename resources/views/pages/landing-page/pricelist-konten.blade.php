<div class="container mb-3">
    <div class="row m-4">
        <div class="col-lg-6 mb-3 mb-lg-0" style="align-self: center;">
            <h1 class="text-uppercase ps-0 fs-lg-7 fs-5 fw-bolder text-300 lh-1 position-relative z-index-0">
                PRICELIST
            </h1>
            <h1
                class="d-none d-md-block fw-bolder text-outlined ps-0 fs-lg-7 fs-sm-6 fs-5 text-white lh-1 mt-sm-n4 mt-n3 position-relative z-index--1">
                SWEET MORIES
            </h1>
        </div>

        <div class="col-lg-6">

            @forelse ($displayProducts as $data)
                <hr>
                <div class="mb-2">
                    <h3>
                        @if ($data->products->promo === 'true')
                            {{ $data->products->name }} {{ $data->products->type }}
                            {{ $data->products->sub_title_promo }} (S&K berlaku)
                        @else
                            {{ $data->products->name }} {{ $data->products->type }} (Bebas syarat & ketentuan)
                        @endif
                    </h3>
                    <ul>
                        @if (!empty($data->products->tnc))
                            @foreach (json_decode($data->products->tnc, true) as $term)
                                <li>
                                    <h5>{{ $term ?? 'Tidak Ada Data' }}</h5>
                                </li>
                            @endforeach
                        @else
                            <span>Tidak Ada Data</span>
                        @endif
                    </ul>
                    @if ($data->products->promo === 'true')
                        <div class="mb-2">
                            Syarat & Ketentuan : {{ $data->products->note }}
                        </div>
                        <h3 class="text-warning">
                            Price
                            <del>
                                {{ $data->products->price_text }}
                            </del>
                            <span class="text-danger">
                                {{ $data->products->price_promo_text }}
                            </span>
                        </h3>
                    @else
                        <h3 class="text-warning">
                            Price {{ $data->products->price_text }}
                        </h3>
                    @endif


                </div>
            @empty
                <div class="mb-2">
                    <h3>Belum Ada Data</h3>
                </div>
            @endforelse

            <hr>

            <div class="mb-2">
                <h3>Additional Print</h3>
                <ul>
                    @forelse ($productAddtionalLP as $productAddtional)
                        <li>
                            <div class="card mb-3">
                                <div class="d-flex">
                                    <div style="width: 100px;">
                                        <img class="card-img card-img-left"
                                            src="{{ $productAddtional->getPicProductAdditional() }}" alt="Card image"
                                            style="width: 100%; height: auto;">
                                    </div>
                                    <div class="flex-grow-1 ms-3 d-flex flex-column justify-content-center">
                                        <h4 class="card-text m-0">
                                            {{ $productAddtional->name }}
                                        </h4>
                                        <h5 class="card-text m-0 text-warning">
                                            {{ $productAddtional->price_text }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </li>

                    @empty
                    @endforelse
                </ul>
            </div>

            <hr>
        </div>
    </div>
</div>
