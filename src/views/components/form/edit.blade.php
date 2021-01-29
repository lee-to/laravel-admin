<div class="w-full">
    {!! $resource->extensions("editTabs", $item) !!}

    @include('admin::components.form.partials.errors', ["errors" => $errors])

    <form class="bg-white shadow-md rounded mb-4" action="{{ $resource->route(($item->exists ? "update" : "store"), $item->id) }}" method="POST" enctype="multipart/form-data">

        {{ csrf_field() }}

        @if($item->exists)
            @method("PUT")
        @endif

        @foreach($resource->formFields() as $index => $field)
            {{ $resource->component($item, $field, "fields") }}
        @endforeach

        <div class="px-10 py-10 bg-blue-100">
            @include('admin::components.form.partials.btn', ["type" => "submit", "class" => "", "name" => trans("admin.save")])
        </div>
    </form>
</div>