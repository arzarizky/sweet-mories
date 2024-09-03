<li class="nav-item px-2 position-relative"><a class="nav-link pt-0 {{ request()->segment(1) == '' ? 'active' : '' }}"
        aria-current="page" href="{{ route('home-landing') }}">Home</a></li>
<li class="nav-item px-2 position-relative"><a
        class="nav-link pt-0 {{ request()->segment(1) == 'about' ? 'active' : '' }}" aria-current="page"
        href="{{ route('about-landing') }}">About</a>
</li>
<li class="nav-item px-2 position-relative"><a
        class="nav-link pt-0 {{ request()->segment(1) == 'gallery' ? 'active' : '' }}" aria-current="page"
        href="{{ route('gallery-landing') }}/#!">Gallery</a>
</li>
<li class="nav-item px-2 position-relative"><a
        class="nav-link pt-0 {{ request()->segment(1) == 'pricelist' ? 'active' : '' }}" aria-current="page"
        href="{{ route('pricelist-landing') }}">Pricelist</a>
</li>
<li class="nav-item px-2 position-relative"><a
        class="nav-link pt-0 {{ request()->segment(1) == 'location' ? 'active' : '' }}" aria-current="page"
        href="https://maps.app.goo.gl/kce3me62MCWKZ2UJA" target="_blank">Location</a>
</li>
<li class="nav-item px-2 position-relative"><a
        class="nav-link pt-0 {{ request()->segment(1) == 'book-now' ? 'active' : '' }}" aria-current="page"
        href="{{ route('book-now-landing') }}">Book Now</a>
</li>
