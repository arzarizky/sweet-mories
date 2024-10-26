@if (Auth::check())
    @foreach ($displayProducts as $data)
        <div class="modal fade" id="modal-book-{{ $data->id }}" tabindex="-1"
            aria-labelledby="modal-book-{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="p-4">
                        <h3>
                            {{ $data->products->name }} {{ $data->products->type }}
                            @if ($data->products->promo === 'true')
                                {{ $data->products->sub_title_promo }}
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
                        @endif

                        @if ($data->products->promo === 'true')
                            <h3>
                                Price
                                <del class="text-warning">
                                    {{ $data->products->price_text }}
                                </del>
                                <span class="text-danger">
                                    {{ $data->products->price_promo_text }}
                                </span>
                            </h3>
                        @else
                            <h3>
                                Price {{ $data->products->price_text }}
                            </h3>
                        @endif


                        <a href="{{ route('book-preview', ['email' => Auth::user()->email , 'package' => $data->id]) }}"
                            style="text-decoration: none; cursor: pointer;" class="text-warning">
                            BOOK NOW
                            <img class="ms-1"
                                src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    @foreach ($displayProducts as $data)
        <div class="modal fade" id="modal-book-{{ $data->id }}" tabindex="-1"
            aria-labelledby="modal-book-{{ $data->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="p-4 mt-2 mb-2">
                        <h3 class="text-center mt-1">HARAP LOGIN TERLEBIH DAHULU</h3>
                        <div class="d-flex justify-content-center mt-4">
                            <form method="gey" action="{{ route('redirectLoginGoogle') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$data->id}}">
                                <button type="submit" class="btn btn-outline-dark">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                            tag="i"
                                            class="v-icon notranslate v-theme--light v-icon--size-default iconify iconify--bxl"
                                            width="50px" height="50px" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28a5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934a8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934c0-.528-.081-1.097-.202-1.625z">
                                            </path>
                                        </svg>
                                    </span>
                                    Login/Register With Google
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
