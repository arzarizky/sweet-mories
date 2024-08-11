<li class="nav-item"><a
        class="nav-link d-inline-block nav-text-outlined lh-1 text-white fs-5 {{ request()->segment(1) == '' ? 'active' : '' }}"
        aria-current="page" href="{{ route('home-landing') }}">Home</a></li>
<li class="nav-item"><a
        class="nav-link d-inline-block nav-text-outlined lh-1 text-white fs-5 {{ request()->segment(1) == 'portfolio' ? 'active' : '' }}"
        aria-current="page" href="{{ route('portfolio-landing') }}">Portfolio</a>
</li>
<li class="nav-item"><a
        class="nav-link d-inline-block nav-text-outlined lh-1 text-white fs-5 {{ request()->segment(1) == 'gallery' ? 'active' : '' }}"
        aria-current="page" href="{{ route('gallery-landing') }}">Gallery</a></li>
<li class="nav-item"><a
        class="nav-link d-inline-block nav-text-outlined lh-1 text-white fs-5 {{ request()->segment(1) == 'exhibitions' ? 'active' : '' }}"
        aria-current="page" href="{{ route('exhibitions-landing') }}">Exhibitions</a>
</li>
<li class="nav-item"><a
        class="nav-link d-inline-block nav-text-outlined lh-1 text-white fs-5 {{ request()->segment(1) == 'about' ? 'active' : '' }}"
        aria-current="page" href="{{ route('about-landing') }}">About</a>
</li>
<li class="nav-item"><a
        class="nav-link d-inline-block nav-text-outlined lh-1 text-white fs-5 {{ request()->segment(1) == 'book-now' ? 'active' : '' }}"
        aria-current="page" href="{{ route('book-now-landing') }}">Book Now</a>
</li>
