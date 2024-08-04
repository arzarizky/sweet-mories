<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar layout-without-menu">
    <div class="layout-container">
        <!-- Layout container -->

        <div class="layout-page">
            {{-- Navbar --}}
            <nav class="layout-navbar nav-sticky-top navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                @include('layouts.navbar')
            </nav>
            {{-- Navbar --}}

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Layout Demo -->
                    @yield('konten')
                    <!--/ Layout Demo -->
                </div>
                <!-- / Content -->

                {{-- Footer --}}
                <footer class="content-footer footer bg-footer-theme mt-3">
                    @include('layouts.footer')
                </footer>
                {{-- Footer --}}

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>
</div>
<!-- / Layout wrapper -->
