<div class="w-full">
    @if (isset($errors) && $errors->any())
        @foreach ($errors->all() as $error)
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>{{ $error }}</p>
            </div>
        @endforeach
    @endif

    <form class="bg-white shadow-md rounded mb-4" action="{{ $resource->route(($item->exists ? "update" : "store"), $item->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

        @if($item->exists)
            @method("PUT")
        @endif

        @foreach($resource->formFields() as $index => $field)
            <div @if($field->type != "hidden") class="@if(($index+1) < count($resource->formFields())) mb-4 @endif border-b px-10 py-5" @endif>
                <div>
                    {{ $resource->component($item, $field, "fields") }}
                </div>

                @error($field->name())
                    <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        @endforeach

        <div class="px-10 py-10 bg-blue-100">
            <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                {{ trans("admin.save") }}
            </button>
        </div>
    </form>
</div>