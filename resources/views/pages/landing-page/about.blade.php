<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>About | Sweet Moris</title>


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
                        <div class="mt-4 d-none d-lg-block">
                            <h1 class="text-uppercase fs-lg-7 fs-5 fw-bolder text-300 lh-1 position-relative z-index-0">
                                About</h1>
                            <h1
                                class="d-none d-md-block fw-bolder text-outlined fs-7 text-white lh-1 mt-n4 position-relative z-index--1">
                                Service</h1>
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
                                    About</h1>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <ul class="navbar-nav navbar-fotogency ms-auto text-end">
                                    @include('pages.landing-page.menus')
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0 mt-4 d-lg-none">
                    <h1 class="text-uppercase ps-0 fs-lg-7 fs-5 fw-bolder text-300 lh-1 position-relative z-index-0">
                        About</h1>
                    <h1
                        class="fw-bolder text-outlined ps-0 fs-lg-7 fs-sm-6 fs-5 text-white lh-1 mt-sm-n4 mt-n3 position-relative z-index--1">
                        Our Team</h1>
                </div>
            </div>
        </nav>


        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-2">

            <div class="container px-md-5">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex justify-content-center">
                                <div class="card border-0 mb-3"><img class="card-img-top"
                                        src="{{ asset('template-landing') }}/public/assets/img/team/img1.png"
                                        alt="" />
                                    <div class="row g-0 card-body px-0 pt-2">
                                        <div class="col-12 col-xl-12 text-center text-xl-start">
                                            <h4>Self photo studio</h4>
                                            <p class="text-warning mb-2">
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 d-flex justify-content-center">
                                <div class="card border-0 mb-3"><img class="card-img-top"
                                        src="{{ asset('template-landing') }}/public/assets/img/team/img2.png"
                                        alt="" />
                                    <div class="row g-0 card-body px-0 pt-2">
                                        <div class="col-12 col-xl-12 text-center text-xl-start">
                                            <h4>Self projector Photo studio</h4>
                                            <p class="text-warning mb-2">
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 d-flex justify-content-center">
                                <div class="card border-0 mb-3"><img class="card-img-top"
                                        src="{{ asset('template-landing') }}/public/assets/img/team/img3.png"
                                        alt="" />
                                    <div class="row g-0 card-body px-0 pt-2">
                                        <div class="col-12 col-xl-12 text-center text-xl-start">
                                            <h4>Holoflip photo</h4>
                                            <p class="text-warning mb-2">
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 d-flex justify-content-center">
                                <div class="card border-0 mb-3"><img class="card-img-top"
                                        src="{{ asset('template-landing') }}/public/assets/img/team/img4.png"
                                        alt="" />
                                    <div class="row g-0 card-body px-0 pt-2">
                                        <div class="col-12 col-xl-12 text-center text-xl-start">
                                            <h4>Cozy place</h4>
                                            <p class="text-warning mb-2">
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 d-flex justify-content-center">
                                <div class="card border-0 mb-3"><img class="card-img-top"
                                        src="{{ asset('template-landing') }}/public/assets/img/team/img5.png"
                                        alt="" />
                                    <div class="row g-0 card-body px-0 pt-2">
                                        <div class="col-12 col-xl-12 text-center text-xl-start">
                                            <h4>Concept update every 3 months</h4>
                                            <p class="text-warning mb-2">
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                                Lorem Ipsum Lorem Ipsum Lorem Ipsum
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
