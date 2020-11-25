@if(isset($resource->actions["edit"]))
    <a href="{{ $resource->route("edit", $item->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-block">
        @include("admin::partials.icons.edit", ["size" => 6, "class" => "mr-2", "color" => "gray"])
    </a>
@endif

@if(isset($resource->actions["delete"]))
    <x-modal>
        {{ trans("admin.deleteareyousure") }}

        <x-slot name="icon">
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </x-slot>

        <x-slot name="title">{{ trans("admin.deleting") }}</x-slot>

        <x-slot name="buttons">
            <div class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <form method="POST" action="{{ $resource->route("destroy", $item->id) }}">
                    {{ csrf_field() }}

                    @method("delete")

                    <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        {{ trans("admin.confirm") }}
                    </button>
                </form>
            </div>
            <div class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button x-on:click="isOpen = false" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    {{ trans("admin.cancel") }}
                </button>
            </div>
        </x-slot>

        <x-slot name="outerHtml">
            <button x-on:click="isOpen = !isOpen" type="button" class="text-indigo-600 hover:text-indigo-900 inline-block">
                @include("admin::partials.icons.delete", ["size" => 6, "class" => "mr-2", "color" => "red"])
            </button>
        </x-slot>
    </x-modal>
@endif