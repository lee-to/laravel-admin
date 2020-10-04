@extends("admin::layout.app")

@section('sidebar-inner')
    @parent

    <div class="text-center mt-8">
        <a href="{{ $resource->route("index") }}" class="bg-blue-500 hover:bg-blue text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            {{ trans('admin.back') }}
        </a>
    </div>
@endsection

@section('header-inner')
    @parent
@endsection

@section('header-inner')
    @parent
@endsection

@section('content')
    @include("admin::partials.title", ["title" => $resource->title])

    <div class="mt-8"></div>

    <div class="flex flex-col mt-8">
        @include("admin::components.form.edit", ["item" => $item])
    </div>
@endsection