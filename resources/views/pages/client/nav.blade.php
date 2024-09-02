<ul class="nav nav-pills flex-column flex-md-row mb-3"
    style="
            position: sticky;
            padding-top: 23px;
            padding-bottom: 5px;
            margin-top: -23px;
            top: 77px;
            z-index: 1;
            background-color: rgba(245, 245, 245, 0.50) !important;
            backdrop-filter: saturate(200%) blur(8px);
            ">
    <li class="nav-item">
        <a class="nav-link {{ url()->current() == route('client-dashboard', ['email' => $users->email]) ? 'active' : '' }}"
            href="{{ route('client-dashboard', ['email' => $users->email]) }}">
            <i class="bx bx-user me-1"></i>
            Account
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->segment(2) == 'booking' ? 'active' : '' }}"
            href="{{ route('client-booking', ['email' => $users->email]) }}">
            <i class='menu-icon tf-icons bx bxs-shopping-bags'></i>
            Booking
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->segment(2) == 'invoice' ? 'active' : '' }}"
            href="{{ route('client-invoice', ['email' => $users->email]) }}">
            <i class='menu-icon tf-icons bx bxs-receipt'></i>
            Invoice
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="pages-account-settings-connections.html"><i class="bx bx-link-alt me-1"></i>
            Connections</a>
    </li> --}}
</ul>
