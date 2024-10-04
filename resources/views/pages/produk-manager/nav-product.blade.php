<div class="card p-2 mb-3">
    <nav class="nav nav-pills nav-justified">
        <a class="nav-link " aria-current="page" href="#">DISPLAY</a>
        <a class="nav-link {{ request()->segment(2) == 'product-main' ? 'active' : '' }}" href="{{route("product-manager-product-main")}}">MAIN</a>
        <a class="nav-link" href="#">ADDITIONAL</a>
        <a class="nav-link" href="#">BACKGROUND</a>
    </nav>

</div>

