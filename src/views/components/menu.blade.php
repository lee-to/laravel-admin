<nav class="mt-10">
    @foreach($data as $menu)
        @include("admin::components.partials.menu-item", ["menu" => $menu])
    @endforeach
</nav>