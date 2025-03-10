{{-- Dashboards --}}
<li class="menu-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboards">Dashboards</div>
    </a>
</li>
{{-- / Dashboards --}}

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Pages</span>
</li>

{{-- Product Manager --}}
<li class="menu-item {{ request()->segment(1) == 'product-manager' ? 'active' : '' }}">
    <a href="{{ route('product-manager-product-main') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-purchase-tag-alt'></i>
        <div data-i18n="Product Manager">Product Manager</div>
    </a>
</li>
{{-- / Product Manager --}}

{{-- Booking Manager --}}
<li class="menu-item {{ request()->segment(1) == 'booking-manager' ? 'active' : '' }}">
    <a href="{{ route('booking-manager') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-shopping-bags'></i>
        <div data-i18n="Booking Manager">Booking Manager</div>
    </a>
</li>
{{-- / Booking Manager --}}

{{-- Promo Manager --}}
<li class="menu-item {{ request()->segment(1) == 'promo-manager' ? 'active' : '' }}">
    <a href="{{ route('promo-manager') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-offer'></i>
        <div data-i18n="Booking Manager">Promo Manager</div>
    </a>
</li>
{{-- / Booking Manager --}}

{{-- Invoice Manager --}}
<li class="menu-item {{ request()->segment(1) == 'invoice-manager' ? 'active' : '' }}">
    <a href="{{ route('invoice-manager') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-receipt'></i>
        <div data-i18n="Invoice Manager">Invoice Manager</div>
    </a>
</li>
{{-- / Invoice Manager --}}

{{-- User Manager --}}
<li class="menu-item {{ request()->segment(1) == 'user-manager' ? 'active' : '' }}">
    <a href="{{ route('user-manager') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-user-account'></i>
        <div data-i18n="User Manager">User Manager</div>
    </a>
</li>
{{-- / User Manager --}}

{{-- User Manager --}}
<li class="menu-item {{ request()->segment(1) == 'outlet' ? 'active' : '' }}">
    <a href="{{ route('outlet') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-user-account'></i>
        <div data-i18n="User Manager">Outlet Setting</div>
    </a>
</li>
{{-- / User Manager --}}
