@if($resource->filters())
    <div class="flex items-center select-none">
        <span>{{ trans('admin.filters') }}</span>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen"
                    class="ml-3 bg-gray-400 dark:bg-gray-600
                    dark:text-gray-400 rounded-full p-2 focus:outline-none
                    hover:text-blue-500 hover:bg-blue-300 transition
                    duration-500 ease-in-out">
                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                    <path
                            d="M14 12v7.88c.04.3-.06.62-.29.83a.996.996 0
                            01-1.41 0l-2.01-2.01a.989.989 0
                            01-.29-.83V12h-.03L4.21 4.62a1 1 0
                            01.17-1.4c.19-.14.4-.22.62-.22h14c.22 0
                            .43.08.62.22a1 1 0 01.17 1.4L14.03 12H14z"></path>
                </svg>
            </button>

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"
                 style="display: none;"></div>

            <div x-show="dropdownOpen"
                 class="absolute right-0 w-64 px-6 py-6 mt-2 bg-white rounded-md overflow-y-auto h-64 shadow-xl z-10"
                 style="display: none;">

                <form class="w-full max-w-sm" action="{{ $resource->route("index") }}" method="get">
                    {{ csrf_field() }}

                    @foreach($resource->filters() as $filter)
                        <div class="mb-4">
                            <div>
                                {{ $resource->component($filter, "filters", $resource->getModel()) }}
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-5">
                        <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                            {{ trans("admin.search") }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif