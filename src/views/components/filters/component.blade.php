@include("admin::components.fields.partials.label", ["field" => $component])

<div class="mt-5">
    @include("admin::components.filters.{$component->view}", ["item" => $item, "filter" => $component])
</div>