{{-- Brand --}}

<div class="app-brand justify-content-center mb-3">
    <a href="index.html" class="app-brand-link gap-2 mt-4">
        <img class="app-brand-logo demo" height="auto" width="140"
        src="{{ asset('template') }}/assets/img/favicon/black-logo.png" alt="">
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
</div>

<div class="menu-inner-shadow"></div>

{{-- Menus --}}
<ul class="menu-inner py-1">
    @include('layouts.menus')
</ul>
{{-- / Menus --}}
