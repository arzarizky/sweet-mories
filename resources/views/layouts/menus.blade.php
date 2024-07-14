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

{{-- Dashboards --}}
<li class="menu-item {{ request()->segment(1) == 'user-manager' ? 'active' : '' }}">
    <a href="{{ route('user-manager') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bxs-user-account'></i>
        <div data-i18n="User Manager">User Manager</div>
    </a>
</li>
{{-- / Dashboards --}}
