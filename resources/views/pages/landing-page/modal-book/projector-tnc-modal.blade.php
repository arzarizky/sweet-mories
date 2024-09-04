@if (Auth::check())
    <div class="modal fade" id="projector-tncModal" tabindex="-1" aria-labelledby="projector-tncModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="p-4">
                    <h3>Projector Self Photoshoot PROMO GRAND OPENING 45% OFF</h3>
                    <ul>
                        <li>
                            <h5>Unlimited Person</h5>
                        </li>
                        <li>
                            <h5>15 Minutes Photoshoot</h5>
                        </li>
                        <li>
                            <h5>5 Minutes Photo Selection</h5>
                        </li>
                        <li>
                            <h5>Free to choose ALL Projector content</h5>
                        </li>
                        <li>
                            <h5>Free to use ALL PROPS & WARDROBE</h5>
                        </li>
                        <li>
                            <h5>Free ALL COLOR DIGITAL SOFT FILE in Google Drive</h5>
                        </li>
                        <li>
                            <h5>Free 1 Basic Print 4R</h5>
                        </li>
                    </ul>
                    <div class="mb-2">
                        T&C : Tag IGS, Follow IG @Sweetmoriesstudio & Review Google Maps.
                    </div>
                    <h3 class="text-warning">
                        Price <del>90K</del> <span class="text-danger">49K</span>
                    </h3>

                    <form id="projector-tnc-form" method="get" action="{{ route('book-preview', ['email' => Auth::user()->email]) }}">
                        @csrf
                        <a onclick="document.getElementById('projector-tnc-form').submit();" style="text-decoration: none; cursor: pointer;" class="text-warning">
                            BOOK NOW
                            <img class="ms-1" src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" />
                        </a>
                        <input type="hidden" name="package" value="Projector-tnc">
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal fade" id="projector-tncModal" tabindex="-1" aria-labelledby="projector-tncModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="p-4 mt-2 mb-2">
                    <h3 class="text-center mt-1">HARAP LOGIN TERLEBIH DAHULU</h3>
                    <div class="d-flex justify-content-center mt-4">
                        <form method="gey" action="{{ route('redirectLoginGoogle') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        aria-hidden="true" role="img" tag="i"
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
@endif
