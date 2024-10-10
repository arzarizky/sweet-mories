<div class="container mb-3">
    <div class="row">
        @forelse ($displayProducts as $data)
            <div class="col-lg-6 mb-3 mb-lg-4">
                <div class="hover hover-1 text-white rounded">
                    <img class="asset" src="{{ $data->products->getPicProduct() }}" alt="">
                    <div class="hover-overlay"></div>
                    <div class="hover-1-content px-5 py-1">
                        <h3 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white"> <span
                                class="font-weight-light text-warning">{{ $data->products->name }}
                            </span>{{ $data->products->type }}</h3>

                        @if ($data->products->promo === 'true')
                            <h5 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white">
                                PROMO
                                <span class="font-weight-light text-warning">
                                    {{ $data->products->sub_title_promo }}
                                </span>
                            </h5>
                            <h5 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white">(S&K berlaku)</h5>
                            @if ($data->products->promo === 'true')
                                <h4>

                                    <del class="text-warning">
                                        {{ $data->products->price_text }}
                                    </del>
                                    <span class="text-danger">
                                        {{ $data->products->price_promo_text }}
                                    </span>
                                </h4>
                            @else
                                <h4>
                                    {{ $data->products->price_text }}
                                </h4>
                            @endif
                        @else
                            <h5 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white">(Bebas syarat &
                                ketentuan)
                                <h4 class="hover-1-description font-weight-light mb-2 mt-2 text-warning">
                                    {{ $data->products->price_text }}
                                </h4>
                        @endif

                        <a data-bs-toggle="modal" data-bs-target="#modal-book-{{ $data->id }}"
                            style="text-decoration: none; cursor: pointer;" data-bs-toggle="modal"
                            class="hover-1-description font-weight-light mb-0 text-warning">
                            SELECT PACKAGE
                            <img class="ms-1"
                                src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" />
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-6 mb-3 mb-lg-4">
                <div class="hover hover-1 text-white rounded">
                    <img class="asset"
                        src="{{ asset('template-landing') }}/public/assets/img/book-now/projector-self-photoshoot-tnc.jpg"
                        alt="">
                    <div class="hover-overlay"></div>
                    <div class="hover-1-content px-5 py-1">
                        <h3 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white"> <span
                                class="font-weight-light text-warning">Belum Ada Data </span>elum Ada Datat</h3>

                        <h5 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white">Belum Ada Data <span
                                class="font-weight-light text-warning">Belum Ada Data</span></h5>
                        <h5 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white">Belum Ada Data</h5>
                        <h4 class="hover-1-description font-weight-light mb-2 mt-2 text-warning">
                            Belum Ada Data
                        </h4>
                        <a data-bs-toggle="modal" data-bs-target="#projector-tncModal"
                            style="text-decoration: none; cursor: pointer;" data-bs-toggle="modal"
                            class="hover-1-description font-weight-light mb-0 text-warning">
                            Belum Ada Data
                            <img class="ms-1"
                                src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" />
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
