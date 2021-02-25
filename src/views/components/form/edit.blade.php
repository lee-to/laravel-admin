<div class="w-full">
    {!! $resource->extensions("editTabs", $item) !!}

    @include('admin::components.form.partials.errors', ["errors" => $errors])

    <form x-data="adminEditForm()" class="bg-white shadow-md rounded mb-4" action="{{ $resource->route(($item->exists ? "update" : "store"), $item->id) }}" method="POST" enctype="multipart/form-data">

        {{ csrf_field() }}

        @if($item->exists)
            @method("PUT")
        @endif

        @foreach($resource->formFields() as $field)
            {{ $resource->component($field, "fields", $item) }}
        @endforeach

        @if($resource->formTabs()->isNotEmpty())
            <div x-data="{activeTab: '{{ $resource->formTabs()->keys()->first() }}'}">
                <div class="bg-white">
                    <nav class="flex flex-col sm:flex-row">
                        @foreach($resource->formTabs() as $index => $tab)
                            <button :class="{ 'border-b-2 font-medium border-blue-500': activeTab === '{{ $index }}' }"
                                    @click.prevent="activeTab = '{{ $index }}'"
                                    class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none text-blue-500">
                                {{ $tab->name() }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                @foreach($resource->formTabs() as $index => $tab)
                    <div x-show="activeTab === '{{ $index }}'">
                        @foreach($tab->formFields() as $field)
                            {{ $resource->component($field, "fields", $item) }}
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif

        <div class="px-10 py-10 bg-blue-100">
            @include('admin::components.form.partials.btn', ["type" => "submit", "class" => "", "name" => trans("admin.save")])
        </div>
    </form>

    <script>
        function adminEditForm() {
            return {
                @if($resource->whenFieldNames())
                    @foreach($resource->whenFieldNames() as $name)
                        {{ $name }}: '{{ $item->{$name} }}',
                    @endforeach
                @endif
            };
        }
    </script>
</div>