 {{-- Layout wrapper --}}
 <div class="layout-wrapper layout-content-navbar">
    {{-- Layout  --}}
    <div class="layout-container">

        {{-- Side Bar --}}
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            @include('layouts.sidebar')
        </aside>
        {{-- / Side Bar --}}

        {{-- Layout container --}}
        <div class="layout-page">

            {{-- Navbar --}}
            <nav class="layout-navbar nav-sticky-top navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                @include('layouts.navbar')
            </nav>
            {{-- Navbar --}}

            {{-- Content wrapper --}}
            <div class="content-wrapper">

                {{-- Content --}}
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('konten')
                </div>
                {{-- Content --}}

                {{-- Footer --}}
                <footer class="content-footer footer bg-footer-theme mt-3">
                    @include('layouts.footer')
                </footer>
                {{-- Footer --}}

                <div class="content-backdrop fade"></div>

            </div>
            {{-- / Content wrapper --}}
        </div>
        {{-- / Layout page --}}
    </div>
    {{-- / Layout  --}}

    {{-- Overlay --}}
    <div class="layout-overlay layout-menu-toggle"></div>
    {{-- / Overlay --}}

</div>
{{-- / Layout wrapper --}}
