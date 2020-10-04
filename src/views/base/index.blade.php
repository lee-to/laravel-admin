@extends("admin::layout.app")

@section('sidebar-inner')
    @parent

    <div class="text-center mt-8">
        <a href="{{ $resource->route("create") }}" class="bg-blue-500 hover:bg-blue text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            {{ trans('admin.create') }}
        </a>
    </div>
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
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

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

    <a href="{{ $resource->route("create") }}" class="inline-flex  items-center bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
        </svg>

        <span>{{ trans('admin.create') }}</span>
    </a>

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