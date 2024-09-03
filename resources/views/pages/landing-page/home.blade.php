<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Home | sweet Moris</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    @include('pages.landing-page.favicon')


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('template-landing') }}/public/vendors/prism/prism.css" rel="stylesheet">
    <link href="{{ asset('template-landing') }}/public/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('template-landing') }}/public/assets/css/theme.css" rel="stylesheet" />
    <link href="{{ asset('template-landing') }}/public/assets/css/user.css" rel="stylesheet" />

</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="cursor-outer d-none d-md-block"></div>
        <nav class="navbar navbar-light py-3 px-0 overflow-hidden">
            <div class="container px-md-5">
                <div class="row w-100 g-0 justify-content-between">
                    <div class="col-8">
                        <div class="d-inline-block">
                            <a class="navbar-brand pt-0 fs-3 text-black d-flex align-items-center"
                                href="{{ route('home-landing') }}">
                                <img class="img-fluid" src="{{ asset('template') }}/assets/img/favicon/black-logo.png"
                                    height="50px" width="auto" alt="" style="width: 100px; height: auto;" />
                            </a>
                        </div>
                    </div>
                    <div class="col-4 d-lg-none text-end pe-0">
                        <button class="btn p-0 shadow-none text-black fs-2 d-inline-block" data-bs-toggle="offcanvas"
                            data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                            aria-label="Toggle offcanvas navigation"><span class="menu-bar"></span></button>
                    </div>
                    <div class="offcanvas offcanvas-end px-0" id="navbarOffcanvas"
                        aria-labelledby="navbarOffcanvasTitle" aria-hidden="true">
                        <div class="offcanvas-header justify-content-end">
                            <h5 class="visually-hidden offcanvas-title" id="navbarOffcanvasTitle">Menu</h5>
                            <button class="btn p-0 shadow-none text-black fs-2 d-inline text-end" type="button"
                                data-bs-dismiss="offcanvas" aria-label="Close"><span
                                    class="menu-close-bar"></span></button>
                        </div>
                        <div class="offcanvas-body px-0">
                            <div class="d-lg-flex flex-center-start gap-3 overflow-hidden">
                                <ul class="navbar-nav ms-auto fs-4 ps-6">
                                    @include('pages.landing-page.menus-mobile')
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-none d-lg-flex justify-content-end position-relative z-index-1">
                            <div class="position-absolute absolute-centered z-index--1">
                                <h1 class="ms-2 fw-bolder text-outlined text-uppercase text-white pe-none display-1">
                                    Home</h1>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <ul class="navbar-nav navbar-fotogency ms-auto text-end">
                                    @include('pages.landing-page.menus')
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>


        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-4 pt-md-0 pb-8 pb-sm-11 mt-lg-n8">
            <div class="container px-md-5">
                <div class="row">
                    <div class="col-md-9 col-lg-7">
                        <h1 class="fs-4 fs-md-6 fs-xl-7 mb-5 mb-lg-0 position-relative z-index-2">
                            <span class="text-400">
                                Moment we treasure,
                            </span>
                            <span class="fw-thin text-300">
                                captured with pleasure.
                            </span>
                            <a href="{{ route('book-now-landing') }}" class="text-dark"
                                style="text-decoration: underline;">
                                Book now.
                            </a>
                        </h1>
                    </div>
                </div>
                <div class="row mt-md-n6">
                    <div class="col-2 d-none d-lg-block mt-auto"><img class="img-fluid"
                            src="{{ asset('template-landing') }}/public/assets/img/home/img2.jpg" alt="" />
                    </div>
                    <div class="col-1 mt-auto d-none d-lg-block"><a class="scroll-indicator text-warning"
                            href="{{ route('home-landing') }}/#footer"> <span>SCROLL </span><img
                                src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                alt="" /></a></div>
                    <div class="col-lg-7 position-relative">
                        <div class="position-relative overflow-hidden overflow-md-visible"><img class="img-fluid"
                                src="{{ asset('template-landing') }}/public/assets/img/home/img1.jpg" alt="" />
                            <div class="img-circle p-5 p-md-7 rounded-circle"></div>
                            <div class="img-circle-2 p-5 p-md-7 rounded-circle"></div>
                        </div>
                        <div class="position-absolute bottom-n100 col-11 mt-6 d-none d-md-block">
                            <p class="fs-2 lh-1 text-400">
                                Sweetmories merupakan tempat menyimpan kenangan. Mengekspresikan momen kecil dalam
                                setiap kesempatan.
                            </p>
                        </div>
                        <div class="position-absolute start-0 bottom-0 d-lg-none"><a
                                class="scroll-indicator text-warning" href="{{ route('home-landing') }}/#footer">
                                <span>SCROLL </span><img
                                    src="{{ asset('template-landing') }}/public/assets/img/icons/long-arrow.png"
                                    alt="" /></a></div>
                    </div>
                    <div class="col-2 d-none d-lg-block mb-auto"><img class="img-fluid"
                            src="{{ asset('template-landing') }}/public/assets/img/home/img3.jpg" alt="" />
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->


    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    @include('pages.landing-page.footer')

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('template-landing') }}/public/vendors/popper/popper.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/is/is.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/fontawesome/all.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/lodash/lodash.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/prism/prism.js"></script>
    <script src="{{ asset('template-landing') }}/public/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('template-landing') }}/public/assets/js/theme.js"></script>

</body>

</html>
