<div class="container mb-3">
    <div class="row">
        <div class="col-lg-6 mb-3 mb-lg-0">
            <div class="hover hover-1 text-white rounded">
                <img class="asset" src="{{ asset('template') }}/assets/img/illustrations/basic-self.jpeg" alt="">
                <div class="hover-overlay"></div>
                <div class="hover-1-content px-5 py-1">
                    <h3 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white"> <span
                            class="font-weight-light text-warning">Basic </span>Self Photoshoot</h3>
                    <h4 class="hover-1-description font-weight-light mb-2 mt-2 text-white">
                        Rp. 47.000
                    </h4>
                    <form id="basic-form" method="post" action="{{ route('book-now-landing-post') }}">
                        @csrf
                        <input type="hidden" name="package" value="basic">
                    </form>
                    <a id="basic" style="text-decoration: none;  cursor: pointer;"
                        class="hover-1-description font-weight-light mb-0 text-warning">
                        SELECT PACKAGE
                        <img class="ms-1" src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                            alt="" />
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="hover hover-1 text-white rounded">
                <img class="asset" src="{{ asset('template') }}/assets/img/illustrations/self-projector.jpg"
                    alt="">
                <div class="hover-overlay"></div>
                <div class="hover-1-content px-5 py-1">
                    <h3 class="hover-1-title text-uppercase font-weight-bold mb-0 text-white"> <span
                            class="font-weight-light text-warning">Projector </span>Self Photoshoot</h3>
                    <h4 class="hover-1-description font-weight-light mb-2 mt-2 text-white">
                        Rp. 70.000
                    </h4>
                    <form id="projector-form" method="post" action="{{ route('book-now-landing-post') }}">
                        @csrf
                        <input type="hidden" name="package" value="projector">
                    </form>
                    @if (Auth::check())
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="text-decoration: none; cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            class="hover-1-description font-weight-light mb-0 text-warning">
                            SELECT PACKAGE
                            <img class="ms-1"
                                src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" />
                        </a>
                    @else
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                            style="text-decoration: none; cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            class="hover-1-description font-weight-light mb-0 text-warning">
                            SELECT PACKAGE
                            <img class="ms-1"
                                src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" />
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var formBasic = document.getElementById("basic-form");
    document.getElementById("basic").addEventListener("click", function() {
        formBasic.submit();
    });
</script>

<script>
    var formProjector = document.getElementById("projector-form");
    document.getElementById("projector").addEventListener("click", function() {
        formProjector.submit();
    });
</script>
