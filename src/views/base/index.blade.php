@extends("admin::layout.app")

@section('sidebar-inner')
    @parent

    @if(isset($resource->actions["add"]))
        <div class="text-center mt-8">
            <a href="{{ $resource->route("create") }}" class="bg-blue-500 hover:bg-blue text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                {{ trans('admin.create') }}
            </a>
        </div>
    @endif
@endsection

@section('header-inner')
    @parent
@endsection


@section('content')
    @include("admin::partials.title", ["title" => $resource->title])

    <div class="mt-1 mb-4 flex items-center justify-between">
        <span class="text-sm">
            {{ trans('admin.total') }}
            <strong>{{ $resource->paginate()->total() }}</strong>
        </span>
    </div>


    <div class="mt-1 mb-4 flex flex-wrap items-center justify-between">
        @if($resource->search())
            <div class="flex items-center select-none mt-5">
                @include("admin::components.listing.partials.search")
            </div>

        @endif

        @if($resource->exportFields()->count())
            <div class="flex items-center select-none mt-5">
                <a href="{{ $resource->route("index") }}?_export=1" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                    @include("admin::partials.icons.export", ["size" => 4, "class" => "mr-2", "color" => "gray"])

                    <span>{{ trans("admin.export") }}</span>
                </a>
            </div>
        @endif

        @if($resource->filters())
            <div class="flex items-center select-none mt-5">
                @include("admin::components.listing.partials.filters")
            </div>
        @endif
    </div>

    <div class="mt-8"></div>

    @if(isset($resource->actions["add"]))
        <a href="{{ $resource->route("create") }}" class="inline-flex  items-center bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            @include("admin::partials.icons.add", ["size" => 4, "class" => "mr-2", "color" => "blue"])

            <span>{{ trans('admin.create') }}</span>
        </a>
    @endif

    <div class="mt-8"></div>

    <div class="flex flex-col mt-8">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full" x-data="actionBarHandler()" x-init="actionBar('main'); $refs.foot.classList.remove('hidden')">
                    <thead>
                        @include("admin::components.listing.head", [$resource])
                    </thead>

                    <tbody class="bg-white">
                        @include("admin::components.listing.items", [$resource])
                    </tbody>

                    <tfoot x-ref="foot" :class="actionBarOpen ? 'translate-y-0 ease-out' : '-translate-y-full ease-in hidden'" class="hidden">
                        @include("admin::components.listing.foot", [$resource])
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-5">
        {{ $resource->paginate()->links() }}
    </div>
@endsection