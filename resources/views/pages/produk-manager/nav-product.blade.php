<div class="card p-2 mb-3">
    <nav class="nav nav-pills nav-justified">
        <a class="nav-link {{ request()->segment(2) == 'product-display' ? 'active' : '' }}" aria-current="page" href="{{route("product-manager-product-display")}}">DISPLAY</a>
        <a class="nav-link {{ request()->segment(2) == 'product-main' ? 'active' : '' }}" href="{{route("product-manager-product-main")}}">MAIN</a>
        <a class="nav-link {{ request()->segment(2) == 'product-additional' ? 'active' : '' }}" href="{{route ("product-manager-product-addtional")}}">ADDITIONAL</a>
        <a class="nav-link {{ request()->segment(2) == 'product-background' ? 'active' : '' }}" href="{{route("product-manager-product-background")}}">BACKGROUND</a>
    </nav>

</div>

